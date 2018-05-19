@extends('layouts.sites.master')
@section('title', trans('sites.checkout'))
@section('content')
    <div id="content" class="site-content">
        <div class="container">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" itemprop="mainContentOfPage">
                    <article id="post-12" class="post-12 page type-page status-publish hentry no-post-thumbnail entry"
                             itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
                        <h1 class="page-title" itemprop="headline">@lang('sites.carts.checkout')</h1>
                        <div class="entry-content" itemprop="text">
                            @if(count($cartProducts) == 0)
                                <div class="woocommerce">
                                    <p class="cart-empty"> @lang('sites.carts.empty_cart') </p>
                                </div>
                            @else
                                <div class="woocommerce">
                                    @guest
                                        <div class="woocommerce-info"> @lang('sites.order.return_customer')
                                            <a href="{{ route('sites.my-account') }}" class="showlogin"> @lang('sites.order.login') </a>
                                        </div>
                                    @endguest
                                    {!! Form::open([
                                        'name' => 'checkout',
                                        'class' => 'checkout woocommerce-checkout',
                                        'enctype' => 'multipart/form-data',
                                        'method' => 'POST',
                                        'route' => 'sites.order.store',
                                        'id' => 'my-form'
                                    ])!!}
                                        <div class="col2-set animation-left-to-right" id="customer_details">
                                            <div class="col-1">
                                                <div class="woocommerce-billing-fields">
                                                    <h3> @lang('sites.order.billing') </h3>
                                                    <p class="form-row form-row form-row-wide address-field validate-required"
                                                       id="billing_city_field">
                                                        <label for="fileInput" class=""> Cert <abbr class="required" title="required">*</abbr></label>
                                                        <input type="file" id="fileInput">
                                                        <pre id="fileDisplayArea"></pre>
                                                        <input type="hidden" id="text-form" name="text_form">
                                                        <input type="hidden" id="sign-form" name="sign_form">
                                                        <input type="hidden" id="cert" name="cert">
                                                    </p>
                                                    <p class="form-row form-row form-row-wide address-field validate-required"
                                                       id="address_field">
                                                        <label for="phone" class=""> @lang('sites.user.phone')<abbr class="required" title="required">*</abbr></label>
                                                        {!! Form::number('phone', !empty($user) ? $user->phone : '', [
                                                           'class' => 'input-text',
                                                           'id' => 'address',
                                                           'autocomplete' => 'address-line1',
                                                           'placeholder' => 'Street address',
                                                           'required' => '',
                                                        ]) !!}
                                                    </p>
                                                    <p class="form-row form-row form-row-wide address-field validate-required"
                                                       id="address_field">
                                                        <label for="address" class=""> @lang('sites.order.billing-name')
                                                            <abbr class="required" title="required">*</abbr>
                                                        </label>
                                                        {!! Form::text('billing_name', !empty($user) ? $user->first_name . ' ' . $user->last_name : '', [
                                                           'class' => 'input-text',
                                                           'id' => 'address',
                                                           'autocomplete' => 'address-line1',
                                                           'placeholder' => 'Street address',
                                                           'required' => '',
                                                        ]) !!}
                                                    </p>
                                                    <div class="clear"></div>
                                                    <p class="form-row form-row form-row-wide" id="company_field">
                                                        <label for="company" class=""> @lang('sites.order.billing-address') </label>
                                                        {!! Form::text('billing_address', !empty($user) ? $user->address : '', [
                                                            'class' => 'input-text',
                                                            'id' => 'company',
                                                            'autocomplete' => 'organization',
                                                            'required' => '',
                                                        ]) !!}
                                                    </p>
                                                    <p class="form-row form-row form-row-wide address-field validate-required"
                                                       id="address_field">
                                                        <label for="address" class=""> @lang('sites.order.shipping-name') <abbr class="required" title="required">*</abbr></label>
                                                        {!! Form::text('shipping_name', !empty($user) ? $user->first_name . ' ' . $user->last_name : '', [
                                                           'class' => 'input-text',
                                                           'id' => 'address',
                                                           'autocomplete' => 'address-line1',
                                                           'placeholder' => 'Street address',
                                                           'required' => '',
                                                        ]) !!}
                                                    </p>
                                                    <div class="clear"></div>
                                                    <p class="form-row form-row form-row-wide" id="company_field">
                                                        <label for="company" class=""> @lang('sites.order.shipping-address') </label>
                                                        {!! Form::text('shipping_address', !empty($user) ? $user->address : '', [
                                                            'class' => 'input-text',
                                                            'id' => 'company',
                                                            'autocomplete' => 'organization',
                                                            'required' => '',
                                                        ]) !!}
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                        <h3 id="order_review_heading" class="animation-right-to-left"> @lang('sites.order.order') </h3>
                                        <div id="order_review" class="woocommerce-checkout-review-order animation-right-to-left">
                                            <table class="shop_table woocommerce-checkout-review-order-table">
                                                <thead>
                                                <tr>
                                                    <th class="product-name"> @lang('sites.carts.product') </th>
                                                    <th class="product-total"> @lang('sites.carts.total') </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cartProducts as $cartProduct)
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                                {{ $cartProduct->storeProduct->product->name }}
                                                                <strong class="product-quantity">&times; {{$cartProduct->number}}</strong>
                                                                <dl class="variation">
                                                                    <dt class="variation-Color"> @lang('sites.product.color'):</dt>
                                                                    <dd class="variation-Color">
                                                                        <p>{{ $cartProduct->storeProduct->color->name }}</p>
                                                                    </dd>
                                                                    <dt class="variation-Size"> @lang('sites.product.size'):</dt>
                                                                    <dd class="variation-Size">
                                                                        <p>{{ $cartProduct->storeProduct->size->name }}</p>
                                                                    </dd>
                                                                    <dt class="variation-FitType"> @lang('sites.product.type'):</dt>
                                                                    <dd class="variation-FitType">
                                                                        <p>{{ $cartProduct->storeProduct->sex }}</p>
                                                                    </dd>
                                                                </dl>
                                                            </td>
                                                            <td class="product-total">
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">&#36;</span>
                                                                    {{ number_format($cartProduct->price)}}
                                                                </span>
                                                            </td>
                                                            <input type="hidden" name="cartProductIds[]" value="{{ $cartProduct->id }}"/>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr class="cart-subtotal">
                                                    <th> @lang('sites.carts.subtotal') </th>
                                                    <td>
                                                        <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">&#36;</span>
                                                            {{ number_format($price)}}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="shipping">
                                                    <th> @lang('sites.carts.shipping') </th>
                                                    <td data-title="Shipping">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">&#36;</span> 0
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="order-total">
                                                    <th> @lang('sites.carts.total') </th>
                                                    <td><strong>
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">&#36;</span>
                                                                {{ number_format($price)}}
                                                                <input type="hidden" name="price" value="{{$price}}">
                                                            </span>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <div id="payment" class="woocommerce-checkout-payment">
                                                <div class="form-row place-order">
                                                    <noscript>
                                                        Since your browser does not support JavaScript, or it is disabled,
                                                        please ensure you click the <em>Update Totals</em> button before
                                                        placing your order. You may be charged more than the amount stated
                                                        above if you fail to do so. <br/>
                                                        <input type="submit" class="button alt" name="woocommerce_checkout_update_totals"
                                                               value="Update totals"/>
                                                    </noscript>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="user" id="user-infor"/>
                                    {!! Form::close() !!}
                                        {!! Form::submit( trans('sites.order.place'), [
                                        'class' => 'button alt',
                                        'id' => 'submit',
                                        'style' => 'margin-bottom: 40px'
                                    ]) !!}
                                </div>
                            @endif
                        </div><!-- .entry-content -->
                    </article><!-- #post-## -->
                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .container -->
    </div><!-- #content -->
@endsection
@section('script')
    <script src="https://kjur.github.io/jsrsasign/jsrsasign-all-min.js"></script>
    <script>
        window.onload = function () {
            var fileInput = document.getElementById('fileInput');
            var fileDisplayArea = document.getElementById('fileDisplayArea');

            fileInput.addEventListener('change', function (e) {
                var file = fileInput.files[0];
                var reader = new FileReader();

                reader.onload = function (e) {
                    fileDisplayArea.innerText = reader.result;
                    console.log(reader.result.indexOf("\n"));
                    console.log($('#fileDisplayArea').html());
                    console.log("hehe" + reader.result.substr(reader.result.indexOf("\n")));
                }
                reader.readAsText(file);
            });

        }
    </script>
    <script>
        /**
         *  Secure Hash Algorithm (SHA1)
         *  http://www.webtoolkit.info/
         **/
        function SHA1(msg) {
            function rotate_left(n,s) {
                var t4 = ( n<<s ) | (n>>>(32-s));
                return t4;
            };
            function lsb_hex(val) {
                var str="";
                var i;
                var vh;
                var vl;
                for( i=0; i<=6; i+=2 ) {
                    vh = (val>>>(i*4+4))&0x0f;
                    vl = (val>>>(i*4))&0x0f;
                    str += vh.toString(16) + vl.toString(16);
                }
                return str;
            };
            function cvt_hex(val) {
                var str="";
                var i;
                var v;
                for( i=7; i>=0; i-- ) {
                    v = (val>>>(i*4))&0x0f;
                    str += v.toString(16);
                }
                return str;
            };
            function Utf8Encode(string) {
                string = string.replace(/\r\n/g,"\n");
                var utftext = "";
                for (var n = 0; n < string.length; n++) {
                    var c = string.charCodeAt(n);
                    if (c < 128) {
                        utftext += String.fromCharCode(c);
                    }
                    else if((c > 127) && (c < 2048)) {
                        utftext += String.fromCharCode((c >> 6) | 192);
                        utftext += String.fromCharCode((c & 63) | 128);
                    }
                    else {
                        utftext += String.fromCharCode((c >> 12) | 224);
                        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                        utftext += String.fromCharCode((c & 63) | 128);
                    }
                }
                return utftext;
            };
            var blockstart;
            var i, j;
            var W = new Array(80);
            var H0 = 0x67452301;
            var H1 = 0xEFCDAB89;
            var H2 = 0x98BADCFE;
            var H3 = 0x10325476;
            var H4 = 0xC3D2E1F0;
            var A, B, C, D, E;
            var temp;
            msg = Utf8Encode(msg);
            var msg_len = msg.length;
            var word_array = new Array();
            for( i=0; i<msg_len-3; i+=4 ) {
                j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
                    msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
                word_array.push( j );
            }
            switch( msg_len % 4 ) {
                case 0:
                    i = 0x080000000;
                    break;
                case 1:
                    i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000;
                    break;
                case 2:
                    i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
                    break;
                case 3:
                    i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8  | 0x80;
                    break;
            }
            word_array.push( i );
            while( (word_array.length % 16) != 14 ) word_array.push( 0 );
            word_array.push( msg_len>>>29 );
            word_array.push( (msg_len<<3)&0x0ffffffff );
            for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {
                for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
                for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);
                A = H0;
                B = H1;
                C = H2;
                D = H3;
                E = H4;
                for( i= 0; i<=19; i++ ) {
                    temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B,30);
                    B = A;
                    A = temp;
                }
                for( i=20; i<=39; i++ ) {
                    temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B,30);
                    B = A;
                    A = temp;
                }
                for( i=40; i<=59; i++ ) {
                    temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B,30);
                    B = A;
                    A = temp;
                }
                for( i=60; i<=79; i++ ) {
                    temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B,30);
                    B = A;
                    A = temp;
                }
                H0 = (H0 + A) & 0x0ffffffff;
                H1 = (H1 + B) & 0x0ffffffff;
                H2 = (H2 + C) & 0x0ffffffff;
                H3 = (H3 + D) & 0x0ffffffff;
                H4 = (H4 + E) & 0x0ffffffff;
            }
            var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);

            return temp.toLowerCase();
        }
    </script>
    <script>
        $(document).ready(function () {
            $("#submit").click(function (e) {
                var file_cert = $('#fileDisplayArea').html();
                var cert = file_cert.substr(file_cert.indexOf("\n"));
                console.log(cert);
                var privateKey = file_cert.substr('0', file_cert.indexOf("\n"));
                var x = SHA1($('#my-form').html());
                $.ajax({
                    url: '/checkCert',
                    data: {
                        cert: cert,
                    },
                    type: 'POST',
                    success: function (data, status) {
                        if (data.result == 1) {
                            $('#user-infor').val(JSON.stringify(data.data));
                            var rsa = new RSAKey();
                            rsa.readPrivateKeyFromPEMString(privateKey);
                            var hashAlg = 'sha1';
                            var hSig = rsa.sign(x, hashAlg);
                            $("#text-form").val(x);
                            $("#sign-form").val(hSig);
                            $("#cert").val(cert);
                            $("#my-form").submit();
                        } else {
                            alert('Khóa của bạn có vấn đề!')
                        }
                    }
                });
            })
        })
    </script>

@endsection
