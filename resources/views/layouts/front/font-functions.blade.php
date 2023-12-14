{{-- AJAX Message --}}
<script>
    jQuery(document).ready(function($) {
        jQuery('.login-box #memberForm .btn-block').click(function(event) {
            event.preventDefault();

            jQuery('.login-box #memberForm #email').removeClass('is-invalid');
            jQuery('.login-box #memberForm .email-field .invalid-feedback strong').text();
            jQuery('.login-box #memberForm #password').removeClass('is-invalid');
            jQuery('.login-box #memberForm .password-field .invalid-feedback strong').text();

            var email       = jQuery('.login-box #memberForm #email').val();
            var password    = jQuery('.login-box #memberForm #password').val();
            var currentUrl  = jQuery('.login-box #memberForm #currentUrl').val();
            if(email.length == 0){
                jQuery('.login-box #memberForm #email').addClass('is-invalid');
                jQuery('.login-box #memberForm .email-field .invalid-feedback strong').text('email is required');
            }
            if(password.length == 0){
                jQuery('.login-box #memberForm #password').addClass('is-invalid');
                jQuery('.login-box #memberForm .password-field .invalid-feedback strong').text('password is required');
            }
            if(email.length != 0 && password.length != 0){
                jQuery('.login-box #memberForm .btn-block').html('<i class="fa fa-spinner fa-spin"></i>');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('member-login') }}",
                    data: {
                        'email'     : email,
                        'password'  : password,
                        "_token" : "{{ csrf_token() }}",
                    },
                    dataType: 'json', 
                    encode  : true
                }).done(function(data) {
                    var obj = data;
                    if(obj.status.length != 0){
                        if(obj.status === 'success'){
                            window.location = currentUrl;
                        }
                    }
                    return false;
                }).fail(function(data) {
                    jQuery('.login-box #memberForm .btn-block').html('Sign In');
                    var obj = jQuery.parseJSON( data.responseText );
                    jQuery('.login-box #memberForm #email').removeClass('is-invalid');
                    jQuery('.login-box #memberForm .email-field .invalid-feedback strong').text('');
                    jQuery('.login-box #memberForm #password').removeClass('is-invalid');
                jQuery('.login-box #memberForm .password-field .invalid-feedback strong').text('');
                    if(obj.data.error.length != 0){
                        jQuery('.login-box #memberForm #email').addClass('is-invalid');
                        jQuery('.login-box #memberForm .email-field .invalid-feedback strong').text(obj.data.error);
                        if(obj.data.error.email){
                            jQuery('.login-box #memberForm #email').addClass('is-invalid');
                            jQuery('.login-box #memberForm .email-field .invalid-feedback strong').text(obj.data.error.email[0]);
                        }
                    }
                    return false;
                });
            }
        });
    });
</script>
