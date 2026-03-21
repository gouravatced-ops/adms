$(document).ready(function () {
    $("#course_type").on("change", function () {
        var courseTypeId = $(this).val();
        if (courseTypeId) {
            $.ajax({
                url: "/admin/get-courses/" + courseTypeId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#course_name").empty();
                    $("#course_name").append(
                        '<option value="">Select Course Name</option>',
                    );

                    $.each(data.course_names, function (index, course) {
                        $("#course_name").append(
                            '<option value="' +
                                course.id +
                                '">' +
                                course.course_name +
                                "</option>",
                        );
                    });
                },
            });
        } else {
            $("#course_name").empty();
            $("#course_name").append(
                '<option value="">Select Course Name</option>',
            );
        }
    });

    $(document).ready(function () {
        $("#adminListTable").DataTable({
            paging: false, // ❌ disable pagination
            info: false, // ❌ hide "Showing X entries"
            lengthChange: false, // ❌ hide "Show entries dropdown"
            searching: true, // ✅ keep search (optional)
            ordering: true, // ✅ sorting
            autoWidth: false,
            responsive: true,
            language: {
                search: "Search:",
                zeroRecords: "No matching records found",
            },
        });
    });

    // DataTable Initialize
    const studentListTable = $("#studentListTable").DataTable({});

    $("#searchButton").on("click", function () {
        const course_type = $("#course_type option:selected").val();
        const course_name = $("#course_name option:selected").text();
        const pass_state = $("#pass_state").val();

        studentListTable.columns().search("");

        if (course_type) {
            studentListTable.column(3).search(course_type);
        }

        if (course_name && course_name != "Select Course Name") {
            studentListTable.column(4).search(course_name);
        }

        if (pass_state && pass_state != "Select Academic Session") {
            studentListTable.column(5).search(pass_state);
        }

        studentListTable.draw();
    });

    $("#resetButton").on("click", function () {
        location.reload();
    });
});
