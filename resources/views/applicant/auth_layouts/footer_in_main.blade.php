<br>
<style>
    #rs-footer1 {
        position: relative;
        background-color: white;
    }

    #rs-footer1::before,
    #rs-footer1::after {
        content: "";
        position: absolute;
        left: 0;
        width: 100%;
        height: 2px;
    }

    #rs-footer1::before {
        top: 0;
        background: linear-gradient(to right, #ff9800, #2563eb, #ff9800);
    }

    #rs-footer1::after {
        bottom: 0;
        background: linear-gradient(to right, #2563eb, #ff9800, #2563eb);
    }
</style>
<footer id="rs-footer1" class="rs-footer1 py-3 footer footer-transparent d-print-none">

    <div class="footer-bottom">
        <div class="container">
            <center>
                <div class="row y-middle">
                    <div class="col-lg-12">
                        <div class="copyright">

                            <p style="margin: 0px;color: black; font-size:18px;">©
                                <?php echo date('Y'); ?> Jharkhand State Housing Board. All Rights Reserved. | ©
                                Technology Partner : <a
                                    aria-label="COMPUTER Ed. Ranchi - External site that opens in a new window"
                                    href="https://www.computered.in/" target="_blank" title="Image of www.computered.in"
                                    onclick="return confirm('You are being redirected to an external website. Please note that this website is not responsible for external websites content &amp; privacy policies.');"><img
                                        src="{{ asset('assets/lg1.png') }}" style="width:50px; height:50px;" alt=""> <span
                                        style="font-size: 15px;color:#d90a74;font-family:old-bookmark;"> <b>COMPUTER
                                            Ed.</b></span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div>
</footer>