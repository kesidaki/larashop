<div class="container">
	<div class="row mb-3">
		<div class="col-sm-12 col-md-4">
			<h4>Σελίδες</h4>
			<ul>
				<li class="footer-item"><a href="{{ url('/products/videogames') }}">Βιντεοπαιχνίδια</a></li>
				<li class="footer-item"><a href="{{ url('/products/epitrapezia') }}">Επιτραπέζια</a></li>
				<li class="footer-item"><a href="{{ url('/products/accessories') }}">Αξεσουάρ</a></li>
				<li class="footer-item"><a href="{{ url('/sxetika-me-emas') }}">Σχετικά με εμάς</a></li>
				<li class="footer-item"><a href="{{ url('/epikoinonia') }}">Επικοινωνία</a></li>
				<li class="footer-item"><a href="{{ url('/oroi-xrisis') }}">Όροι Χρήσης</a></li>
			</ul>
		</div>

		<div class="col-sm-12 col-md-4">
			<h4>Λογαριασμός</h4>
			<ul>
				@guest
					<li class="footer-item"><a href="{{ route('login') }}">Σύνδεση</a></li>
					<li class="footer-item"><a href="{{ route('register') }}">Εγγραφή</a></li>
				@else
					<li class="footer-item"><a href="{{ url('/') }}">Ο Λογαριασμός μου</a></li>
					<li class="footer-item"><a href="{{ route('logout') }}">Αποσύνδεση</a></li>
				@endguest
			</ul>
		</div>

		<div class="col-sm-12 col-md-4">
			<h4>Επικοινωνία</h4>
			<ul>
				<li class="footer-contact-item">
					Κωνσταντίνος Κεσίδης<br>
					Web Developer<br>
					<a href="https://kesidis-kostas.gr" target="_blank">kesidis-kostas.gr</a><br/>
				</li>
				<li class="footer-contact-item">
					694 3898 195
				</li>
				<li class="footer-contact-item">
					kesidiskostas@gmail.com
				</li>
				<li class="footer-contact-item">
					<a href="#"><i class="fab fa-facebook-f"></i></a>
					<a href="#"><i class="fab fa-twitter"></i></a>
					<a href="#"><i class="fab fa-instagram"></i></a>
					<a href="#"><i class="fab fa-linkedin-in"></i></a>
				</li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 credits">
			<h4 class="text-center">Credits</h4>
			<!--Laravel-->
			<a href="https://laravel.com/" target="_blank"><img src="{{ asset('public/img/credits/laravel.png') }}"></a>
			<!--Laravel-->
			<a href="https://jquery.com/" target="_blank"><img src="{{ asset('public/img/credits/JQuery.png') }}"></a>
			<!--Laravel-->
			<a href="http://getbootstrap.com/" target="_blank"><img src="{{ asset('public/img/credits/bootstrap-4.png') }}"></a>
			<!--Laravel-->
			<a href="https://sass-lang.com/" target="_blank"><img src="{{ asset('public/img/credits/sass.png') }}"></a>
		</div>
	</div>

	<div class="row">
		<p class="copyright">&copy; 2018 {{ (date('Y') > '2018') ? '-'.date('Y') : '' }}</p>
	</div>
</div>