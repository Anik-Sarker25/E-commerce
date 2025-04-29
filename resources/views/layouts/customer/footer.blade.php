<!-- FOOTER -->
<footer class="site-footer footer-opt-1">

    <div class="container">
        <div class="footer-column">

            <div class="row">
                <div class="col-md-3 col-lg-3 col-xs-6 col">
                    <strong class="logo-footer">
                        <a href=""><img src="{{ asset(siteinfo()->site_logo ?? 'frontend/assets/images/media/index1/logo-footer.png') }}" alt="logo"></a>
                    </strong>

                    <table class="address">
                        <tr>
                            <td><b>Address:  </b></td>
                            <td>{{ siteinfo()->address ?? 'Address Gose here' }}</td>
                        </tr>
                        <tr>
                            <td><b>Phone: </b></td>
                            <td>{{ siteinfo()->phone ?? '01234567890' }}</td>
                        </tr>
                        <tr>
                            <td><b>Email:</b></td>
                            <td>{{ siteinfo()->email ?? 'example@gmail.com' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-2 col-lg-2 col-xs-6 col">
                    <div class="links">
                    <h3 class="title">Company</h3>
                    <ul>
                        <li><a href="">About Us</a></li>
                        <li><a href="">Testimonials</a></li>
                        <li><a href="">Affiliate Program</a></li>
                        <li><a href="">Terms & Conditions</a></li>
                        <li><a href="">Terms & Conditions</a></li>
                    </ul>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xs-6 col">
                    <div class="links">
                    <h3 class="title">My Account</h3>
                    <ul>
                        <li><a href="">My Order</a></li>
                        <li><a href="">My Wishlist</a></li>
                        <li><a href="">My Credit Slip</a></li>
                        <li><a href="">My Addresses</a></li>
                        <li><a href="">My Account</a></li>
                    </ul>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xs-6 col">
                    <div class="links">
                    <h3 class="title">Support</h3>
                    <ul>
                        <li><a href="">New User Guide</a></li>
                        <li><a href="">Help Center</a></li>
                        <li><a href="">Refund Policy</a></li>
                        <li><a href="">Report Spam</a></li>
                        <li><a href="">FAQ</a></li>
                    </ul>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-xs-6 col">
                    <div class="block-newletter">
                        <div class="block-title">NEWSLETTER</div>
                        <div class="block-content">
                            <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <span class="input-group-btn">
                                    <button class="btn btn-subcribe" type="button"><span>ok</span></button>
                                </span>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="block-social">
                        <div class="block-title">Let’s Socialize </div>
                        <div class="block-content">
                            @if (socialMedia()->facebook)
                                <a href="{{ socialMedia()->facebook }}" target="_blank" class="facebook">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                            @endif
                            @if (socialMedia()->twitter)
                                <a href="{{ socialMedia()->twitter }}" target="_blank" class="twitter">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            @endif
                            @if (socialMedia()->instagram)
                                <a href="{{ socialMedia()->instagram }}" target="_blank" class="instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            @endif
                            @if (socialMedia()->linkedin)
                                <a href="{{ socialMedia()->linkedin }}" target="_blank" class="linkedin">
                                    <i class="fa-brands fa-linkedin"></i>
                                </a>
                            @endif
                            @if (socialMedia()->youtube)
                                <a href="{{ socialMedia()->youtube }}" target="_blank" class="youtube">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-methods" style="display: flex; align-items: center; justify-content:center;">
            <div class="block-title">
                Accepted Payment Methods
            </div>
            <div class="block-content">
                @forelse ($paymentMethods as $payment)
                    <a href="{{ $payment->link ?? '' }}" target="_blank">
                        <img alt="{{ $payment->name }}" src="{{ asset($payment->image) }}" style="width: 70px; border-radius: 5px; margin-right: 5px;">
                    </a>
                @empty
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment1.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment2.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment3.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment4.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment5.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment6.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment7.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment8.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment9.png') }}">
                    <img alt="payment" src="{{ asset('frontend/assets/images/media/index1/payment10.png') }}">
                @endforelse
            </div>
        </div>

        <div class="footer-links">
            @foreach ($categories as $category)
                @foreach ($category->subcategories->take('5') as $subcategory)
                    @if ($subcategory->products->isNotEmpty())
                        <ul class="links">
                            <li><strong class="title">{{ $subcategory->name }}:</strong></li>

                            @php
                                $hasKeywords = false;
                            @endphp
                            
                            @foreach ($subcategory->products as $product)
                                @if (!empty($product->keywords) && $product->childcategory)
                                    @php
                                        $hasKeywords = true;
                                        $keywords = explode(',', $product->keywords);
                                    @endphp
                                    @foreach ($keywords as $keyword)
                                        <li>
                                            <a href="{{ route('childcategory.show', $product->childcategory->slug) }}?childcat_id={{ $product->childcategory_id }}">
                                                {{ $keyword }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                            
                            @if (!$hasKeywords)
                                <p style="color: red; text-align: center;">keywords not found!</p>
                            @endif
                        </ul>
                    @endif
                @endforeach
            @endforeach
        </div>

        <div class="footer-bottom">
            <div class="links">
                <ul>
                    <li><a href="{{ route('home') }}">    Company Info – Partnerships    </a></li>
                </ul>
                @php
                    $firstGroupLimit = 7;
                    $secondGroupLimit = 10;
                    $thirdGroupLimit = 7;

                    $currentIndex = 0;
                @endphp

                <ul>
                    @foreach ($partnerships as $key => $partner)
                        @if ($partner)
                            @if ($currentIndex < $firstGroupLimit)
                                <!-- First group of 7 -->
                                <li><a href="{{ $partner->link ?? '' }}" target="_blank">{{ $partner->name }}</a></li>
                            @elseif ($currentIndex >= $firstGroupLimit && $currentIndex < ($firstGroupLimit + $secondGroupLimit))
                                <!-- Second group of 10 -->
                                <li><a href="{{ $partner->link ?? '' }}" target="_blank">{{ $partner->name }}</a></li>
                            @elseif ($currentIndex >= ($firstGroupLimit + $secondGroupLimit) && $currentIndex < ($firstGroupLimit + $secondGroupLimit + $thirdGroupLimit))
                                <!-- Third group of 7 -->
                                <li><a href="{{ $partner->link ?? '' }}" target="_blank">{{ $partner->name }}</a></li>
                            @endif

                            @php
                                $currentIndex++;
                            @endphp

                            <!-- Add <br> after each group for line break -->
                            @if ($currentIndex == $firstGroupLimit || $currentIndex == ($firstGroupLimit + $secondGroupLimit))
                                <br>
                            @endif
                        @else
                            <p style="color: red; text-align:center;">No Partnerships!</p>
                        @endif
                    @endforeach
                </ul>

            </div>
        </div>

        <div class="copyright">

            {{ siteInfo()->copyright ?? 'Copyright © 2016. All Rights Reserved by Ecommerce' }}

        </div>

    </div>

</footer><!-- end FOOTER -->
