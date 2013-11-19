<?php
ini_set('memory_limit', '5000M');
set_time_limit(0);

class sitemapUtils {
	public static function generateSitemapEntries(sfEvent $event) {
		$hosts = Doctrine::getTable("Video") -> findByIsPublish(1);

		$o_sitemapSectionBiens = new prestaSitemapSection('video');
		// check is it is up-to-date
		if (!$o_sitemapSectionBiens -> isUpToDate()) {
			$urls = Doctrine::getTable("Video") -> getSlug();
			foreach ($urls AS $url) {

				$o_sitemapSectionBiens -> addUrl(new prestaSitemapUrl('http://v3.ergor.org/video/telecharger/' . $url[0], new DateTime(), prestaSitemapUrl::CHANGE_FREQUENCY_HOURLY));

			}
		}

		$hosts = Doctrine::getTable("Jeu") -> findByIsPublish(1);

		$o_sitemapSectionBiens = new prestaSitemapSection('jeu');
		// check is it is up-to-date
		if (!$o_sitemapSectionBiens -> isUpToDate()) {
			$urls = Doctrine::getTable("Jeu") -> getSlug();
			foreach ($urls AS $url) {

				$o_sitemapSectionBiens -> addUrl(new prestaSitemapUrl('http://v3.ergor.org/jeu/telecharger/' . $url[0], new DateTime(), prestaSitemapUrl::CHANGE_FREQUENCY_HOURLY));

			}
		}
		
		$hosts = Doctrine::getTable("Logiciel") -> findByIsPublish(1);

		$o_sitemapSectionBiens = new prestaSitemapSection('logiciel');
		// check is it is up-to-date
		if (!$o_sitemapSectionBiens -> isUpToDate()) {
			$urls = Doctrine::getTable("Logiciel") -> getSlug();
			foreach ($urls AS $url) {

				$o_sitemapSectionBiens -> addUrl(new prestaSitemapUrl('http://v3.ergor.org/logiciel/telecharger/' . $url[0], new DateTime(), prestaSitemapUrl::CHANGE_FREQUENCY_HOURLY));

			}
		}

		$hosts = Doctrine::getTable("Musique") -> findByIsPublish(1);

		$o_sitemapSectionBiens = new prestaSitemapSection('musique');
		// check is it is up-to-date
		if (!$o_sitemapSectionBiens -> isUpToDate()) {
			$urls = Doctrine::getTable("Musique") -> getSlug();
			foreach ($urls AS $url) {

				$o_sitemapSectionBiens -> addUrl(new prestaSitemapUrl('http://v3.ergor.org/musique/telecharger/' . $url[0], new DateTime(), prestaSitemapUrl::CHANGE_FREQUENCY_HOURLY));

			}
		}

		$hosts = Doctrine::getTable("Ebook") -> findByIsPublish(1);

		$o_sitemapSectionBiens = new prestaSitemapSection('ebook');
		// check is it is up-to-date
		if (!$o_sitemapSectionBiens -> isUpToDate()) {
			$urls = Doctrine::getTable("Ebook") -> getSlug();
			foreach ($urls AS $url) {

				$o_sitemapSectionBiens -> addUrl(new prestaSitemapUrl('http://v3.ergor.org/ebook/telecharger/' . $url[0], new DateTime(), prestaSitemapUrl::CHANGE_FREQUENCY_HOURLY));

			}
		}
		$hosts = Doctrine::getTable("Diver") -> findByIsPublish(1);

		$o_sitemapSectionBiens = new prestaSitemapSection('diver');
		// check is it is up-to-date
		if (!$o_sitemapSectionBiens -> isUpToDate()) {
			$urls = Doctrine::getTable("Diver") -> getSlug();
			foreach ($urls AS $url) {

				$o_sitemapSectionBiens -> addUrl(new prestaSitemapUrl('http://v3.ergor.org/diver/telecharger/' . $url[0], new DateTime(), prestaSitemapUrl::CHANGE_FREQUENCY_HOURLY));

			}
		}

	}

}
