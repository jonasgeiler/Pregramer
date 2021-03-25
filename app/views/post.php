<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Meta tags and links taken from Instagram... -->
		<meta name="robots" content="noimageindex, noarchive" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="mobile-web-app-capable" content="yes" />
		<meta name="theme-color" content="#ffffff" />
		<link rel="manifest" href="/instagram-manifest.json" />
		<link rel="apple-touch-icon-precomposed" sizes="76x76" href="https://www.instagram.com/static/images/ico/apple-touch-icon-76x76-precomposed.png/666282be8229.png" />
		<link rel="apple-touch-icon-precomposed" sizes="120x120" href="https://www.instagram.com/static/images/ico/apple-touch-icon-120x120-precomposed.png/8a5bd3f267b1.png" />
		<link rel="apple-touch-icon-precomposed" sizes="152x152" href="https://www.instagram.com/static/images/ico/apple-touch-icon-152x152-precomposed.png/68193576ffc5.png" />
		<link rel="apple-touch-icon-precomposed" sizes="167x167" href="https://www.instagram.com/static/images/ico/apple-touch-icon-167x167-precomposed.png/4985e31c9100.png" />
		<link rel="apple-touch-icon-precomposed" sizes="180x180" href="https://www.instagram.com/static/images/ico/apple-touch-icon-180x180-precomposed.png/c06fdb2357bd.png" />
		<link rel="icon" sizes="192x192" href="https://www.instagram.com/static/images/ico/favicon-192.png/68d99ba29cc8.png" />
		<link rel="mask-icon" href="https://www.instagram.com/static/images/ico/favicon.svg/fc72dd4bfde8.svg" color="#262626" />
		<link rel="shortcut icon" type="image/x-icon" href="https://www.instagram.com/static/images/ico/favicon.ico/36b3ee2d91ed.ico" />
		<link rel="alternate" href="android-app://com.instagram.android/https/instagram.com/p/<?= $media['shortCode'] ?>/" />
		<meta property="al:ios:app_name" content="Instagram" />
		<meta property="al:ios:app_store_id" content="389801252" />
		<meta property="al:ios:url" content="instagram://media?id=<?= $media['id'] ?>" />
		<meta property="al:android:app_name" content="Instagram" />
		<meta property="al:android:package" content="com.instagram.android" />
		<meta property="al:android:url" content="<?= $url ?>" />
		<meta property="al:web:url" content="<?= $url ?>" />

		<!-- Site Info -->
		<title><?= $title ?></title>
		<meta name="title" content="<?= $title ?>" />
		<meta name="description" content="<?= $description ?>" />

		<!-- Open Graph / Facebook -->
		<meta property="og:url" content="<?= $url ?>" />
		<meta property="og:site_name" content="Instagram" />
		<meta property="og:title" content="<?= $title ?>" />
		<meta property="og:description" content="<?= $description ?>" />
		<?php if ($media['type'] == 'video'): ?>
			<meta property="og:type" content="video.other" />
			<meta property="og:video" content="<?= $media['videoStandardResolutionUrl'] ?>" />
			<meta property="og:video:secure_url" content="<?= $media['videoStandardResolutionUrl'] ?>" />
			<meta property="og:image" content="<?= $media['imageHighResolutionUrl'] ?>" />
		<?php else: ?>
			<meta property="og:type" content="website" />
			<?php if ($media['type'] == 'sidecar'): ?>
				<?php foreach ($media['sidecarMedias'] as $sidecarMedia): ?>
					<meta property="og:image" content="<?= $sidecarMedia['imageHighResolutionUrl'] ?>" />
					<meta property="og:image:alt" content="<?= $sidecarMedia['altText'] ?>" />
				<?php endforeach; ?>
			<?php elseif ($media['type'] == 'image'): ?>
				<meta property="og:image" content="<?= $media['imageHighResolutionUrl'] ?>" />
				<meta property="og:image:alt" content="<?= $media['altText'] ?>" />
			<?php endif; ?>
		<?php endif; ?>

		<!-- Twitter -->
		<meta property="twitter:url" content="<?= $url ?>" />
		<meta property="twitter:site" content="@instagram" />
		<meta property="twitter:title" content="<?= $title ?>" />
		<meta property="twitter:description" content="<?= $description ?>" />
		<meta property="twitter:image" content="<?= $media['imageHighResolutionUrl'] ?>" />
		<?php if ($media['type'] == 'video'): ?>
			<meta property="twitter:card" content="player" />
			<meta property="twitter:player" content="<?= $url ?>embed" />
			<meta property="twitter:player:width" content="612" />
			<meta property="twitter:player:height" content="710" />
			<meta property="twitter:player:stream" content="<?= $media['videoStandardResolutionUrl'] ?>" />
		<?php else: ?>
			<meta property="twitter:card" content="summary_large_image" />
			<?php if ($media['type'] == 'image'): ?>
				<meta property="twitter:image:alt" content="<?= $media['altText'] ?>" />
			<?php endif; ?>
		<?php endif; ?>


		<script type="text/javascript">
			window.location.href = '<?= $url ?>';
		</script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
		<style type="text/css">
			body {
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
			}

			.header {
				text-align: center;
			}

			.instagram-media {
				max-width: 540px;
				width: 99.375%;
				width: -webkit-calc(100% - 2px);
				width: calc(100% - 2px);
			}
		</style>
	</head>
	<body>
		<div class="header">
			<h1>&#x1F5BC; Pregramer</h1>
			<p>Redirecting you to Instagram...</p>
		</div>
		
		<blockquote class="instagram-media" data-instgrm-permalink="<?= $url ?>" data-instgrm-version="13"></blockquote>
		<script async src="https://www.instagram.com/embed.js"></script>
	</body>
</html>