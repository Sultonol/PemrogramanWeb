<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Shah Islamic Center</title>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Open Sans', sans-serif;
		}

		body {
			background-color: #fdf6f0;
		}

		header {
			height: 100vh;
			color: white;
			position: relative;
		}

		header .bg-img {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
			z-index: -1;
		}

		nav {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 1.5rem 4rem;
			background-color: rgba(0, 0, 0, 0.6);
		}

		nav img {
			height: 50px;
		}

		nav ul {
			display: flex;
			gap: 1.5rem;
			list-style: none;
		}

		nav ul li a {
			text-decoration: none;
			color: white;
			font-weight: bold;
		}

		.hero-text {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			text-align: center;
			padding: 3rem;
			border-radius: 20px;
		}

		.hero-text h1 {
			color: #333;
			padding: 2rem;
			font-size: 2.5rem;
			border-radius: 12px;
			display: inline-block;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
			/* text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7); */
		}

		.hero-text p {
			margin-bottom: 1.5rem;
			font-style: italic;
			color: #333;
		}

		.hero-text a {
			background-color: #f4a261;
			padding: 0.75rem 1.5rem;
			color: white;
			text-decoration: none;
			font-weight: bold;
			border-radius: 5px;
		}

		section {
			padding: 4rem 2rem;
			display: flex;
			justify-content: space-around;
			flex-wrap: wrap;
		}

		.prayer-times,
		.welcome {
			width: 45%;
			background-color: white;
			padding: 2rem;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			margin-bottom: 2rem;
		}

		.prayer-times h2,
		.welcome h2 {
			font-family: 'Cinzel', serif;
			color: #8d5524;
			margin-bottom: 1rem;
		}

		.philosophy {
			background-color: #fff;
			text-align: center;
			padding: 4rem 2rem;
		}

		.philosophy h2 {
			font-family: 'Cinzel', serif;
			font-size: 2rem;
			margin-bottom: 2rem;
		}

		.philosophy .items {
			display: flex;
			justify-content: center;
			flex-wrap: wrap;
			gap: 2rem;
		}

		.philosophy .item {
			width: 200px;
		}

		.philosophy .item h4 {
			margin: 0.5rem 0;
			font-size: 1.1rem;
		}

		footer {
			text-align: center;
			padding: 1rem;
			background-color: #222;
			color: white;
		}
	</style>
</head>

<body>

	<header>
		<img src="/img/people.jpg" alt="Background" class="bg-img">
		<nav>
			<img src="/img/logo.png" alt="Logo">
			<ul>
				<li><a href="">Home</a></li>
				<li><a href="">About</a></li>
				<li><a href="">Contact Us</a></li>
			</ul>
		</nav>
		<div class="hero-text">
			<h1>"AND ALLAH INVITES TO THE HOME OF PEACE"</h1>
			<p>Surah Yunus, Verse 25</p>
			<a href="index.php?page=login">Get Started</a>
		</div>
	</header>

	<section>
		<div class="prayer-times">
			<h2>Prayer Times in Jakarta</h2>
			<p>Fajr: 04:39</p>
			<p>Sunrise: 05:58</p>
			<p>Dhuhr: 11:58</p>
			<p>Asr: 15:18</p>
			<p>Maghrib: 17:57</p>
			<p>Isha: 19:12</p>
		</div>
		<div class="welcome">
			<h2>Welcome to the Islamic Center</h2>
			<p>The Shahid is not just a mosque for prayers rather it is a community center for all. The Center is committed to preserving Islamic identity, building and supporting a viable Muslim community, promoting comprehensive Islamic way of life based on the Holy Qur’an and the Sunnah of Prophet Muhammad ﷺ.</p>
			<br>
			<a href="#" style="background-color:#2a9d8f; color:white; padding:10px 15px; text-decoration:none; border-radius:4px;">Read More</a>
		</div>
	</section>

	<section class="philosophy">
		<h2>Our Philosophy</h2>
		<div class="items">
			<div class="item">
				<img src="https://img.icons8.com/ios-filled/50/book.png" alt="Knowledge" />
				<h4>Knowledge</h4>
				<p>A central aspect of Islam is learning and teaching.</p>
			</div>
			<div class="item">
				<img src="https://img.icons8.com/ios-filled/50/moon-symbol.png" alt="Spirituality" />
				<h4>Spirituality</h4>
				<p>Islam has the way of our Messenger ﷺ.</p>
			</div>
			<div class="item">
				<img src="https://img.icons8.com/ios-filled/50/groups.png" alt="Community" />
				<h4>Community</h4>
				<p>We grow together, we break fast together, Islam is community.</p>
			</div>
			<div class="item">
				<img src="https://img.icons8.com/ios-filled/50/helping-hand.png" alt="Service" />
				<h4>Service</h4>
				<p>Helping others is core in the life of every Muslim.</p>
			</div>
		</div>
		<br>
		<a href="#" style="background-color:#f4a261; color:white; padding:10px 20px; text-decoration:none; border-radius:4px;">View More</a>
	</section>

	<footer>
		&copy; 2025 Shah Islamic Center. All rights reserved.
	</footer>

</body>

</html>