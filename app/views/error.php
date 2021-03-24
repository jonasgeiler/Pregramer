<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">

		<title><?= $title ?> - InstaPrev, by Skayo</title>

		<link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
		<link rel="manifest" href="/manifest.json">

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
		<style type="text/css">
			body {
				height: 100vh;
				margin-top: 0;
				margin-bottom: 0;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
			}

			.code {
				font-size: 5em;
			}

			.message {
				color: var(--text-muted);
			}

			.error {
				max-width: 100%;
			}
		</style>
	</head>
	<body>
		<h1 class="code"><?= $code ?></h1>
		<h3 class="message"><?= strtoupper($message) ?></h3>

		<?php if (isset($error)): ?>
			<br />
			<pre class="error"><code><b><?= $error['message'] ?> (<?= $error['code'] ?>)</b>

<?= $error['trace'] ?></code></pre>
		<?php endif; ?>
	</body>
</html>