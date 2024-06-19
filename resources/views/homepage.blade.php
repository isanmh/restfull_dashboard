@extends('layouts.main')

@section('content')
    <section id="Banner">
        <div class="row">
            {{-- typograpgy --}}
            <div data-aos="fade-right" data-aos-duration="2000" data-aos-delay="200"
                class="col-md-6 pt-5 pt-lg-5 d-flex justify-content-center flex-column order-lg-1 order-2">
                <h1>Bring Us To A Digital Culture with
                    <strong class="text-primary">Infotech Global Indonesia</strong>
                </h1>
                <p class="my-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto pariatur mollitia rem
                    magnam facilis.
                    Maiores minus accusantium perspiciatis quisquam saepe eum aliquid et exercitationem, alias qui fugiat,
                    earum, voluptas nisi.
                </p>
                <div class="mt-4">
                    <a href="/about" class="btn btn-outline-primary">Get Started</a>
                </div>
            </div>
            {{-- image --}}
            <div data-aos="zoom-in" data-aos-duration="3000" data-aos-delay="200"
                class="col-md-6 pt-5 pt-lg-5 order-lg-2 order-1">
                <img src="{{ asset('assets/images/banner.svg') }}" alt="logo" class="img-fluid animasi">
            </div>
        </div>
    </section>
@endsection
