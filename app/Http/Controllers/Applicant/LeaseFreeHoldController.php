<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allottee;
use App\Models\AllotteeDocument;
use App\Models\DocumentMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LeaseFreeHoldController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = (int) $request->input('per_page', 50);

            $query = Allottee::query()
                ->with([
                    'division:id,id,name',
                    'subDivision:id,id,name',
                    'propertyCategory:id,id,name',
                    'propertyType:id,id,name',
                    'quarterType:quarter_id,quarter_code'
                ])
                ->where('is_free_hold_completed', 0)
                ->where('free_hold_status', 'yes')

                ->when($request->filled('allottee'), function ($q) use ($request) {
                    $search = trim($request->allottee);

                    $q->where(function ($sub) use ($search) {
                        $sub->where('allottee_name', 'like', "%{$search}%")
                            ->orWhere('allottee_middle_name', 'like', "%{$search}%")
                            ->orWhere('allottee_surname', 'like', "%{$search}%")
                            ->orWhere('application_no', 'like', "%{$search}%")
                            ->orWhere('register_id', 'like', "%{$search}%");
                    });
                })

                ->when($request->filled('property_no'), function ($q) use ($request) {
                    $q->where('property_number', 'like', '%' . trim($request->property_no) . '%');
                })

                ->when($request->filled('division'), function ($q) use ($request) {
                    $q->where('division_id', $request->division);
                })

                ->latest('id');

            $freeholdAllottee = $query
                ->paginate($perPage)
                ->withQueryString();

            // encrypted id for each row
            $freeholdAllottee->getCollection()->transform(function ($item) {
                $item->encrypted_id = encrypt($item->id);
                return $item;
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'freeholdAllottee' => $freeholdAllottee,
                ]);
            }

            $divisions = getDivisions();

            return view(
                'applicant.components.leasefreehold.index',
                compact('freeholdAllottee', 'divisions')
            );
        } catch (\Throwable $e) {

            \Log::error('Free Hold Allottee List Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            $message = app()->environment('production')
                ? 'Unable to load free hold allottee list.'
                : $e->getMessage();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 500);
            }

            return back()->with('error', $message);
        }
    }

    public function completedIndex(Request $request)
    {
        try {
            $perPage = (int) $request->input('per_page', 50);

            $query = Allottee::query()
                ->with([
                    'division:id,id,name',
                    'subDivision:id,id,name',
                    'propertyCategory:id,id,name',
                    'propertyType:id,id,name',
                    'quarterType:quarter_id,quarter_code'
                ])
                ->where('is_free_hold_completed', 1)
                ->where('free_hold_status', 'yes')

                ->when($request->filled('allottee'), function ($q) use ($request) {
                    $search = trim($request->allottee);

                    $q->where(function ($sub) use ($search) {
                        $sub->where('allottee_name', 'like', "%{$search}%")
                            ->orWhere('allottee_middle_name', 'like', "%{$search}%")
                            ->orWhere('allottee_surname', 'like', "%{$search}%")
                            ->orWhere('application_no', 'like', "%{$search}%")
                            ->orWhere('register_id', 'like', "%{$search}%");
                    });
                })

                ->when($request->filled('property_no'), function ($q) use ($request) {
                    $q->where('property_number', 'like', '%' . trim($request->property_no) . '%');
                })

                ->when($request->filled('division'), function ($q) use ($request) {
                    $q->where('division_id', $request->division);
                })

                ->latest('id');

            $freeholdAllottee = $query
                ->paginate($perPage)
                ->withQueryString();

            // encrypted id for each row
            $freeholdAllottee->getCollection()->transform(function ($item) {
                $item->encrypted_id = encrypt($item->id);
                return $item;
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'freeholdAllottee' => $freeholdAllottee,
                ]);
            }

            $divisions = getDivisions();

            return view(
                'applicant.components.leasefreehold.completeindex',
                compact('freeholdAllottee', 'divisions')
            );
        } catch (\Throwable $e) {

            \Log::error('Free Hold Allottee List Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            $message = app()->environment('production')
                ? 'Unable to load free hold allottee list.'
                : $e->getMessage();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 500);
            }

            return back()->with('error', $message);
        }
    }

    public function documentUpload(string $encryptedId)
    {
        try {
            $allotteeId = decrypt($encryptedId);

            $file = Allottee::findOrFail($allotteeId);
            $file->freehold_upload_document_path = $file->allottee_document_path . '/freehold/';

            // All master documents for free hold
            $masterDocuments = DocumentMaster::query()
                ->where('document_category', 'freehold')
                ->where('status', 1)
                ->orderBy('sort_order')
                ->get();

            $totalDocument = $masterDocuments->count();

            // Already uploaded documents of this allottee
            $uploadedDocuments = AllotteeDocument::query()
                ->where('allottee_id', $allotteeId)
                ->get()
                ->keyBy('document_id');

            $completedDocuments = collect();
            $remainingDocuments = collect();

            foreach ($masterDocuments as $document) {

                $uploaded = $uploadedDocuments->get($document->id);

                // document is completed only when file path exists
                $isCompleted = $uploaded;

                $documentData = (object) [
                    'id'            => $document->id,
                    'document_name' => $document->document_name,
                    'document_key'  => $document->document_key,
                    'sort_order'    => $document->sort_order,
                    'upload'        => $uploaded,
                    'is_completed'  => $isCompleted,
                    'full_file_path' => $isCompleted
                        ? asset(ltrim($uploaded->file_path, '/'))
                        : null,
                ];

                if ($isCompleted) {
                    $completedDocuments->push($documentData);
                } else {
                    $remainingDocuments->push($documentData);
                }
            }

            // optional: if all documents uploaded then mark complete
            $isAllDocumentsCompleted = $remainingDocuments->isEmpty();
            // return [$file, $completedDocuments, $remainingDocuments, $isAllDocumentsCompleted];

            return view(
                'applicant.components.leasefreehold.upload',
                compact(
                    'file',
                    'completedDocuments',
                    'remainingDocuments',
                    'totalDocument',
                    'isAllDocumentsCompleted'
                )
            );
        } catch (\Throwable $e) {

            \Log::error('Free Hold Document Upload Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unable to open free hold document upload page.'
                );
        }
    }

    public function uploadDocument(Request $request)
    {
        try {
            $validated = $request->validate([
                'allottee_id'   => ['required', 'exists:allottees,id'],
                'document_id'   => ['required', 'exists:document_master,id'],
                'document_file' => ['nullable', 'file', 'max:10240'],
                'remarks'       => ['nullable', 'string', 'required_without:document_file'],
                'uploadpath'    => ['required', 'string'],
                // New fields for document details
                'doc_no'        => ['nullable', 'string', 'max:100'],
                'day'           => ['nullable', 'string', 'max:2'],
                'month'         => ['nullable', 'string', 'max:2'],
                'year'          => ['nullable', 'string', 'max:4'],
                'additional_info' => ['nullable', 'string', 'max:500'],
            ]);

            $allotteeId = $validated['allottee_id'];
            $documentId = $validated['document_id'];

            $applicant = Allottee::with([
                'division:id,division_code',
                'subDivision:id,subdivision_code',
                'quarterType:quarter_id,quarter_code',
            ])->findOrFail($allotteeId);

            $document = DocumentMaster::select('id', 'document_key')
                ->findOrFail($documentId);

            $documentRow = AllotteeDocument::firstOrNew([
                'allottee_id' => $allotteeId,
                'document_id' => $documentId,
            ]);

            $filePath = $documentRow->file_path;
            $fileName = $documentRow->file_name;

            // Handle file upload if present
            if ($request->hasFile('document_file')) {

                $uploadPath = trim($validated['uploadpath'], '/');
                $folderPath = public_path($uploadPath);

                if (!is_dir($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }

                // Remove old file on re-upload
                if (!empty($documentRow->file_path)) {
                    $oldFilePath = public_path($documentRow->file_path);
                    if (file_exists($oldFilePath)) {
                        @unlink($oldFilePath);
                    }
                }

                $divisionCode    = $applicant->division->division_code ?? '';
                $subDivisionCode = $applicant->subDivision->subdivision_code ?? '';
                $quarterCode     = $applicant->quarterType->quarter_code ?? '';
                $year            = $applicant->allotment_year ?? date('Y');
                $month           = str_pad($applicant->allotment_month ?? date('m'), 2, '0', STR_PAD_LEFT);

                $propertyNo = preg_replace(
                    '/[^A-Za-z0-9]/',
                    '-',
                    $applicant->property_number ?? 'property'
                );

                $extension = $request->file('document_file')->getClientOriginalExtension();

                $fileName = sprintf(
                    '%s%s%s%s%s-%s_%s_%s.%s',
                    $divisionCode,
                    $subDivisionCode,
                    $quarterCode,
                    $year,
                    $month,
                    $propertyNo,
                    $document->document_key,
                    random_int(1000, 9999),
                    $extension
                );

                $request->file('document_file')->move($folderPath, $fileName);

                $filePath = $uploadPath . '/' . $fileName;
            }

            // Prepare document date from day/month/year if provided
            $documentDate = null;
            if (!empty($validated['day']) && !empty($validated['month']) && !empty($validated['year'])) {
                try {
                    $documentDate = sprintf(
                        '%04d-%02d-%02d',
                        $validated['year'],
                        $validated['month'],
                        $validated['day']
                    );
                } catch (\Exception $e) {
                    // Invalid date, skip
                }
            }

            // Fill the document row with all fields
            $documentRow->fill([
                'doc_no'          => $validated['doc_no'] ?? $documentRow->doc_no,
                'doc_day'         => $validated['day'] ?? $documentRow->doc_day,
                'doc_month'       => $validated['month'] ?? $documentRow->doc_month,
                'doc_year'        => $validated['year'] ?? $documentRow->doc_year,
                'document_date'   => $documentDate ?? $documentRow->document_date,
                'additional_info' => $validated['additional_info'] ?? $documentRow->additional_info,
                'remarks'         => $validated['remarks'] ?? $documentRow->remarks,
                'file_path'       => $filePath,
                'file_name'       => $fileName,
                'uploaded_by'     => auth()->id(),
            ])->save();

            // Get all required freehold documents
            $requiredDocumentIds = DocumentMaster::where('document_category', 'freehold')
                ->where('status', 1)
                ->pluck('id');

            // Count uploaded documents (with file OR remarks)
            $uploadedCount = AllotteeDocument::where('allottee_id', $allotteeId)
                ->whereIn('document_id', $requiredDocumentIds)
                ->where(function ($query) {
                    $query->whereNotNull('file_path')
                        ->where('file_path', '!=', '')
                        ->orWhereNotNull('remarks')
                        ->where('remarks', '!=', '');
                })
                ->distinct('document_id')
                ->count('document_id');

            // Check if all documents are completed (file uploaded OR remarks provided)
            $isCompleted = $uploadedCount === $requiredDocumentIds->count();

            // Update the allottee status
            Allottee::where('id', $allotteeId)->update([
                'is_free_hold_completed' => 1,
            ]);

            $response = [
                'success'   => true,
                'message'   => 'Document uploaded successfully.',
                'data'      => [
                    'allottee_id'            => $allotteeId,
                    'document_id'            => $documentId,
                    'file_name'              => $fileName,
                    'file_path'              => $filePath,
                    'doc_no'                 => $validated['doc_no'] ?? null,
                    'document_date'          => $documentDate,
                    'additional_info'        => $validated['additional_info'] ?? null,
                    'remarks'                => $validated['remarks'] ?? null,
                    'uploaded_documents'     => $uploadedCount,
                    'required_documents'     => $requiredDocumentIds->count(),
                    'is_free_hold_completed' => $isCompleted,
                ],
            ];

            return $request->ajax()
                ? response()->json($response)
                : back()->with('success', $response['message']);
        } catch (\Throwable $e) {
            \Log::error('Free Hold Document Upload Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
                'request' => $request->all(),
            ]);

            $message = app()->environment('production')
                ? 'Unable to upload document. Please try again.'
                : $e->getMessage();

            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500)
                : back()->withInput()->with('error', $message);
        }
    }
}
