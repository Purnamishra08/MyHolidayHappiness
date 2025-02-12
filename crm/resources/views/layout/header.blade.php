 <!-- header -->

    <header class="header">

      <div class="container">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

          <a class="navbar-brand" href="{{ URL::to('/') }}">

            <img src="{{ asset('img/logo-white.png') }}" alt="logo">

          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="true" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

          </button>

          <div class="navbar-collapse collapse" id="navbarColor01">

            <ul class="navbar-nav ml-auto">

              <li class="nav-item">

                <a class="nav-link active" href="{{ URL::to('/') }}">Home </a>

              </li>

              <li class="nav-item">

                <a class="nav-link"  href="{{ URL::to('/about-us') }}">About us </a>

              </li>

              <li class="nav-item">

                <a class="nav-link" href="{{ URL::to('/referrals') }}">Referrals </a>

              </li>

              <li class="nav-item">

                <a class="nav-link" href="{{ URL::to('/services') }}">Services </a>

              </li>

              <li class="nav-item">

                <a class="nav-link" href="{{ URL::to('/testimonial') }}">Testimonial </a>

              </li>

              <li class="nav-item">

                <a class="nav-link" href="{{ URL::to('/contact') }}">Contact </a>

              </li>

            </ul>

          </div>

        </nav>

      </div>

    </header>

    <!-- end header -->