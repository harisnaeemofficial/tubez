<?php require('config.php'); ?>

<!doctype html>
<html lang="en">
<head>
	<title><?= $WEBSITE_TITLE ?></title>

	<meta charset="utf-8">
	<meta name="description" content="<?= $WEBSITE_DESCRIPTION ?>">
	<meta name="keywords" content="<?= $WEBSITE_KEYWORDS ?>">

	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/skeleton.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row header">
			<div class="five columns">
				<h1 class="site_title"><a href="<?= APP_URL ?>"><?= $WEBSITE_HEADING ?></a></h1>
			</div>
		</div>

		<div class="row">
			<form method="get">
				<div class="nine columns" style="width:78%;">
					<input value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>" type="text" placeholder="https://youtube.com/watch?v=P9-FCC6I7u0 or just P9-FCC6I7u0" name="q">
				</div>
				<div class="three columns" style="margin-left:0;">
					<select name="t"><option value="v">Download</option><option value="s" <?= isset($_GET['t']) && $_GET['t'] == 's' ? ' selected' : '' ?>>Search</option></select>
					<input type="submit" value="GO" class="button-primary right">
				</div>
			</form>
		</div>

		<?php

		if(isset($_GET['q']) && isset($_GET['t'])) {

			?>

			<div class="clearfix h30"></div>

			<?php

			if($_GET['t'] == 's') {

				?>
				<h4>Search Results for "<?= $_GET['q'] ?>"</h4>

				<div class="clearfix h30"></div>
				<?php

				require_once 'vendor/autoload.php';

				$client = new Google_Client();
  				$client->setDeveloperKey($YOUTUBE_API_DEVELOPER_KEY);

  				$youtube = new Google_Service_YouTube($client);

  				try {

  					$searchResponse = $youtube->search->listSearch('id,snippet', array(
				      'q' => $_GET['q'],
				      'maxResults' => $YOUTUBE_SEARCH_MAXRESULTS,
				    ));

					foreach ($searchResponse['items'] as $searchResult) {
						switch ($searchResult['id']['kind']) {
						case 'youtube#video':
							$thevideo = array(
								"title" => $searchResult['snippet']['title'],
								"vid" => $searchResult['id']['videoId'],
								"thumbnail" => $searchResult['snippet']['thumbnails']['medium']['url']
							);
							?>
							<div class="row">
								<div class="three columns">
									<img src="<?= $thevideo['thumbnail'] ?>" alt="<?= $thevideo['title'] ?>">
								</div>
								<div class="six columns csix">
									<h5 class="left stitle"><?= $thevideo['title'] ?></h5>
								</div>
								<div class="three columns">
									<a href="/?t=v&q=<?= $thevideo['vid'] ?>" class="button right">Download</a>
								</div>
							</div>

							<hr>
							<?php
							break;
						}
					}
  				} catch (Google_Service_Exception $e) {
  					?>
					<div class="row">
						<div class="twelve columns error">
							<?= htmlspecialchars($e->getMessage()) ?>
						</div>
					</div>
					<?php
  				}
			}
			else if($_GET['t'] == 'v') {

				$jsondata = json_decode(file_get_contents( API_URL . '?v=' . $_GET['q']));

				print '<!-- '.$jsondata->status.'-->';

				if($jsondata->status == "error") {
					?>
					<div class="row">
						<div class="twelve columns error">
							<?= $jsondata->status_message ?>
						</div>
					</div>
					<?php
				}
				else {

					$vlist = array_reverse($jsondata->data);

					?>

					<div class="row">
						<div class="twelve columns">
							<h5><?= $jsondata->title ?></h5>
							<img src="<?= $jsondata->thumbnail ?>" alt="<?= $jsondata->title ?>">
						</div>
					</div>

					<div class="clearfix h30"></div>
					<?php

					foreach($vlist as $list) {

						$dname = str_replace(" ", "+", $jsondata->title);
						$list->url .= "&title=" . $dname;

						?>
						<div class="row">
							<div class="nine columns">
								<h6><?= $list->format_note ?> - <?= $list->format ?></h6>
							</div>
							<div class="three columns">
								<a class="button right" href="<?= $list->url ?>">Download</a>
							</div>
						</div>

						<hr>
						<?php
					}
				}
			}
		}

		?>

		<div class="clearfix h30"></div>

		<div class="row footer">
			<div class="twelve columns">
				<span>Copyright &copy; <?= date('Y') . ' ' . APP_NAME ?></span>
			</div>
		</div>
	</div>
</body>