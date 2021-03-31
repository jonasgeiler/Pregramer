<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="theme-color" content="#0096bf" />

		<title><?= $status ?> - Pregramer, by Skayo</title>

		<link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png" />
		<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png" />
		<link rel="manifest" href="/manifest.json" />

		<script async defer data-domain="pregramer.link" src="https://analytics.skayo.dev/js/plausible.js"></script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
		<style type="text/css">
			body {
				height:          100vh;
				margin-top:      0;
				margin-bottom:   0;
				display:         flex;
				flex-direction:  column;
				justify-content: center;
				align-items:     center;
			}

			.code {
				margin-bottom: 0;
				font-size:     6em;
			}

			.message {
				margin-top: 0;
				color:      var(--text-muted);
				text-align: center;
			}

			.error {
				max-width: 100%;
			}
		</style>
	</head>
	<body>
		<h1 class="code"><?= $code ?></h1>
		<h2 class="message"><?= strtoupper($status) ?></h2>

		<?php if (!$this->fw->PRODUCTION): ?>
			<pre class="error"><code><b><?= $text ?></b>

<?= $trace ?></code></pre>
		<?php endif; ?>

		<hr />
		<a href="/">Back to Homepage</a>
	</body>
</html>
