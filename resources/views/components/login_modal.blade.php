<!--  Popup Newsletter-->
<div class="modal fade loginModal popup-newsletter" id="popup-newsletter" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-image: url('{{ asset('frontend/assets/images/media/detail/loginbg.png') }}');">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="block-newletter">
                <div class="box-authentication" style="border: none;">
                    <form id="modalLoginForm">
                        <h3>Already registered?</h3>
                        <div class="form-group">
                            <input type="hidden" id="product_id" value="">
                            <input type="hidden" id="quantity" value="">
                            <label for="email">Email address</label>
                            <input type="text" name="email" class="form-control" id="email">
                            <span class="text-danger" id="emailError"></span>
                        </div>
                        <div class="form-group">
                             <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password">

                            <span class="text-danger" id="passwordError"></span>
                        </div>
                        <p class="forgot-pass"><a href="#">Forgot your password?</a></p>

                        <span class="text-danger" id="genaralError"></span>

                        <button type="button" class="btn button cartLoginBtn" onclick="cartLogin()"><i class="fa fa-lock"></i> Sign in
                            <span class="glyphicon glyphicon-refresh glyphicon-spin" style="display: none;" id="loadingSpinner"></span>

                        </button>
                        <div class="text-center" style="margin-top: 20px;">Don't have an account? <a href="{{ route('register') }}" style="color: #f36;">Sign up now</a></div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div><!--  Popup Newsletter-->
