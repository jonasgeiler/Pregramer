<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Pregramer, by Skayo</title>

		<link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
		<link rel="manifest" href="/manifest.json">

		<meta name="title" content="Pregramer, by Skayo" />
		<meta name="description" content="Beautiful Social Media Share Previews for your Instagram Posts 📸" />

		<meta property="og:type" content="website" />
		<meta property="og:url" content="https://pregramer.link" />
		<meta property="og:site_name" content="Pregramer" />
		<meta property="og:title" content="Pregramer, by Skayo" />
		<meta property="og:description" content="Beautiful Social Media Share Previews for your Instagram Posts 📸" />
		<meta property="og:image" content="/img/social-preview.png" />

		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:url" content="https://pregramer.link" />
		<meta name="twitter:title" content="Pregramer, by Skayo" />
		<meta name="twitter:description" content="Beautiful Social Media Share Previews for your Instagram Posts 📸" />
		<meta name="twitter:image" content="/img/social-preview.png" />

		<script async defer data-domain="pregramer.link" src="https://analytics.skayo.dev/js/plausible.js"></script>

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
				display: flex;
				flex-direction: column;
				margin-bottom: 3rem;
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

			.input-error {
				box-shadow: 0 0 0 2px #ef4444 !important;
			}

			footer {
				text-align: center;
			}

			@media (min-width: 768px) {
				body {
					margin-top: 0;
				}

				main {
					display: flex;
					flex-direction: row;
					justify-content: center;
					align-items: center;
				}

				.left-col {
					width: 50%;
					min-height: 100vh;
					margin-right: 2rem;
					margin-bottom: 0;
					justify-content: center;
				}

				.right-col {
					width: 50%;
					min-height: 100vh;
					margin-left: 2rem;
					justify-content: center;
					align-items: center;
				}

				footer {
					margin-top: 0 !important;
				}
			}
		</style>
	</head>
	<body>
		<main>
			<div class="left-col">
				<h2 class="branding">&#x1F5BC; Pregramer</h2>
				<h1 class="title">Beautiful Social Media Share Previews for your Instagram Posts.</h1>

				<label for="input-link">Paste Instagram Link:</label>
				<input id="input-link" type="url" placeholder="https://www.instagram.com/p/..." />

				<div id="result" style="display: none">
					<span id="result-arrow">&#8595;</span>

					<label for="result-link">Your Pregramer Link:</label>
					<input id="result-link" type="url" readonly />

					<div>
						<button id="copy-button"><span id="copy-button-feedback"></span> Copy to clipboard</button>
					</div>
				</div>
			</div>

			<div class="right-col">
				<div>
					<p>Before... &#x1F928;</p>
					<blockquote class="twitter-tweet" data-dnt="true"><p lang="und" dir="ltr"><a href="https://t.co/cyRUfgo1Sr">https://t.co/cyRUfgo1Sr</a></p>&mdash; 𝙎𝙆𝘼𝙔𝙊 🌾 (@Skayo_) <a href="https://twitter.com/Skayo_/status/1375037477522702336?ref_src=twsrc%5Etfw">March 25, 2021</a></blockquote>
				</div>

				<div>
					<p style="margin-top: 2rem;">After... &#x1F60D;</p>
					<blockquote class="twitter-tweet" data-dnt="true"><p lang="und" dir="ltr"><a href="https://t.co/Y8xLp6XgJ1">https://t.co/Y8xLp6XgJ1</a></p>&mdash; 𝙎𝙆𝘼𝙔𝙊 🌾 (@Skayo_) <a href="https://twitter.com/Skayo_/status/1375211692171350020?ref_src=twsrc%5Etfw">March 25, 2021</a></blockquote>
				</div>
			</div>
		</main>

		<footer class="footer">
			<span>Made with &#x2764; by <a href="https://skayo.dev" target="_blank">Skayo</a>
			&bull;
			<a href="/privacy">Privacy Policy</a>
		</footer>

		<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
		<script type="text/javascript">
			const inputLink = document.getElementById('input-link');

			const resultContainer = document.getElementById('result');
			const resultLink = document.getElementById('result-link');

			const copyButton = document.getElementById('copy-button');
			const copyButtonFeedback = document.getElementById('copy-button-feedback');

			const pregramerUrl = new URL(location.href).href;

			let result = '';

			inputLink.addEventListener('input', function () {
				if (inputLink.classList.contains('input-error')) {
					inputLink.classList.remove('input-error');
				}

				if (resultContainer.style.display !== 'none') {
					resultContainer.style.display = 'none';
				}

				if (this.value.trim() === '') return;
				console.log(this.value);

				try {
					const url = new URL(this.value);

					if (!url.hostname.endsWith('instagram.com') || !url.pathname.startsWith('/p/')) {
						inputLink.classList.add('input-error');
						resultContainer.style.display = 'none';
						return;
					}

					result = pregramerUrl + url.pathname.slice(3, url.pathname.length - (url.pathname.endsWith('/') ? 1 : 0));
					resultLink.value = result;
					resultContainer.style.display = null;
				} catch (e) {
					inputLink.classList.add('input-error');
					resultContainer.style.display = 'none';
				}
			});

			copyButton.addEventListener('click', function () {
				clipboardCopy(result)
					.then(() => { copyButtonFeedback.textContent = '✔' })
					.catch(() => { copyButtonFeedback.textContent = '❌' })
					.then(() => setTimeout(() => { copyButtonFeedback.textContent = '' }, 1000))
			});

			function makeError () {
				return new DOMException('The request is not allowed', 'NotAllowedError')
			}

			async function copyClipboardApi (text) {
				// Use the Async Clipboard API when available. Requires a secure browsing
				// context (i.e. HTTPS)
				if (!navigator.clipboard) {
					throw makeError()
				}
				return navigator.clipboard.writeText(text)
			}

			async function copyExecCommand (text) {
				// Put the text to copy into a <span>
				const span = document.createElement('span')
				span.textContent = text

				// Preserve consecutive spaces and newlines
				span.style.whiteSpace = 'pre'
				span.style.webkitUserSelect = 'auto'
				span.style.userSelect = 'all'

				// Add the <span> to the page
				document.body.appendChild(span)

				// Make a selection object representing the range of text selected by the user
				const selection = window.getSelection()
				const range = window.document.createRange()
				selection.removeAllRanges()
				range.selectNode(span)
				selection.addRange(range)

				// Copy text to the clipboard
				let success = false
				try {
					success = window.document.execCommand('copy')
				} finally {
					// Cleanup
					selection.removeAllRanges()
					window.document.body.removeChild(span)
				}

				if (!success) throw makeError()
			}

			async function clipboardCopy (text) {
				try {
					await copyClipboardApi(text)
				} catch (err) {
					// ...Otherwise, use document.execCommand() fallback
					try {
						await copyExecCommand(text)
					} catch (err2) {
						throw (err2 || err || makeError())
					}
				}
			}
		</script>
	</body>
</html>