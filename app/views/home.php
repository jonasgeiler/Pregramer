<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">

		<title>InstaPrev, by Skayo</title>

		<link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
		<link rel="manifest" href="/manifest.json">

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
		<style type="text/css">
			.branding {
				margin-bottom: 0;
			}

			.title {
				font-weight: bolder;
				margin-top: 1rem;
				margin-bottom: 3rem;
			}

			.left-col {
				min-height: 100vh;
				display: flex;
				flex-direction: column;
			}

			.right-col {
				display: flex;
				flex-direction: column;
			}

			#result {
				margin-top: 6px;
				display: flex;
				flex-direction: column;
			}

			#result-arrow {
				text-align: center;
				padding-bottom: 0.5rem;
				font-size: 2.2em;
			}

			#copy-button {
				float: right;
				position: relative;
				overflow: visible;
			}

			#copy-button-feedback {
				position: absolute;
				left: -2rem;
				display: inline-block;
				transform: scale(1.3);
			}

			@media (min-width: 768px) {
				body {
					margin-top: 0;
					margin-bottom: 0;
					display: flex;
					flex-direction: row;
					justify-content: center;
					align-items: center;
				}

				.left-col {
					width: 50%;
					margin-right: 2rem;
					justify-content: center;
				}

				.right-col {
					width: 50%;
					height: 100vh;
					margin-left: 2rem;
					justify-content: center;
					align-items: center;
				}
			}
		</style>
	</head>
	<body>
		<div class="left-col">
			<h2 class="branding">&#x1F5BC; InstaPrev</h2>
			<h1 class="title">Beautiful Social Media Share Previews for your Instagram Posts.</h1>

			<label for="input-link">Paste Instagram Link:</label>
			<input id="input-link" id="input-link" type="url" placeholder="https://www.instagram.com/p/..." />

			<div id="result" style="display: none">
				<span id="result-arrow">&#8595;</span>

				<label for="result-link">Your InstaPrev Link:</label>
				<input id="result-link" type="url" readonly />

				<div>
					<button id="copy-button"><span id="copy-button-feedback"></span> Copy to clipboard</button>
				</div>
			</div>
		</div>

		<div class="right-col">
			<div>
				<p>Before... &#x1F928;</p>
				<blockquote class="twitter-tweet" data-dnt="true"><p lang="und" dir="ltr"><a href="https://t.co/cyRUfgo1Sr">https://t.co/cyRUfgo1Sr</a></p>&mdash; 𝙎𝙆𝘼𝙔𝙊 🌾 (@Skayo_) <a href="https://twitter.com/Skayo_/status/1375037477522702336?ref_src=twsrc%5Etfw">March 25, 2021</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
			</div>

			<div>
				<p style="margin-top: 2rem;">After... &#x1F60D;</p>
				<blockquote class="twitter-tweet" data-dnt="true"><p lang="und" dir="ltr"><a href="https://t.co/qn1bDDKP2r">https://t.co/qn1bDDKP2r</a></p>&mdash; 𝙎𝙆𝘼𝙔𝙊 🌾 (@Skayo_) <a href="https://twitter.com/Skayo_/status/1375037222777454593?ref_src=twsrc%5Etfw">March 25, 2021</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
			</div>
		</div>

		<script type="text/javascript">
			const inputLink = document.getElementById('input-link');

			const resultContainer = document.getElementById('result');
			const resultLink = document.getElementById('result-link');

			const copyButton = document.getElementById('copy-button');
			const copyButtonFeedback = document.getElementById('copy-button-feedback');

			const instaPrevUrl = new URL(location.href).href;

			let result = '';

			inputLink.addEventListener('input', function () {
				const url = new URL(this.value);

				if (url.pathname.startsWith('/p/')) {
					result = instaPrevUrl + url.pathname.slice(3, url.pathname.length - (url.pathname.endsWith('/') ? 1 : 0));
					resultLink.value = result;
					resultContainer.style.display = null;
				}
			});

			copyButton.addEventListener('click', function () {
				const clipboard = navigator.clipboard || window.clipboard;

				clipboard.writeText(result)
					.then(() => { copyButtonFeedback.textContent = '✔' })
					.catch(() => { copyButtonFeedback.textContent = '❌' })
					.then(() => setTimeout(() => { copyButtonFeedback.textContent = '' }, 1000))
			});
		</script>
	</body>
</html>