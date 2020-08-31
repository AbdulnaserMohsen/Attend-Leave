 

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    
    <!-- bottom footer -->
      <div id="bottom-footer" class="section">
        <div class="container">
          <!-- row -->
          <div class="row">
            <div class="col-md-12 text-center wow fadeInDown">
              
              <div class="developer">
                <h3 class="footer-title">{{ __('developer.developed') }}</h3>
                <p><i class="fa fa-user"></i> {{ __('developer.name') }}</p>
                <p><i class="fa fa-map-marker"></i> {{ __('developer.address') }}</p>
                <p><i class="fa fa-mobile"></i> {{ __('developer.mobile') }}</p>
                <p><i class="fa fa-envelope"></i> naserahmed1995@gmail.com</p>
                <a href="https://www.linkedin.com/in/abdulnaser-mohsen-7233a5103/"><i class="fa fa-linkedin"></i></a>
                <a href="https://github.com/AbdulnaserMohsen"><i class="fa fa-github"></i></a>
              </div>
              
            </div>
          </div>
          <!-- /row -->
          <div class="container">
            <div class="copyright">
              &copy; Copyright <strong>Reveal</strong>. All Rights Reserved
            </div>
            <div class="credits">
              <!--
                All the links in the footer should remain intact.
                You can delete the links only if you purchased the pro version.
                Licensing information: https://bootstrapmade.com/license/
                Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Reveal
              -->
              Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
          </div>
        </div>
        <!-- /container -->
      </div>
      <!-- /bottom footer -->

  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('lib/jquery/jquery-migrate.min.js') }}"></script>
  <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
  <script src="{{ asset('lib/superfish/hoverIntent.js') }}"></script>
  <script src="{{ asset('lib/superfish/superfish.min.js') }}"></script>
  <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
  <script src="{{ asset('lib/sticky/sticky.js') }}"></script>


  <!-- Template Main Javascript File -->
  <script src="{{ asset('js/main.js') }}"></script>


  <!-- script to automaticlly chooce home or services -->
    
  @yield('footerJs')

</body>
</html>
