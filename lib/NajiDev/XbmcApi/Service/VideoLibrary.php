<?php

namespace NajiDev\XbmcApi\Service;

use \NajiDev\XbmcApi\Model\Video\Episode,
    \NajiDev\XbmcApi\Model\Video\Movie,
    \NajiDev\XbmcApi\Model\Video\MovieSet,
    \NajiDev\XbmcApi\Model\Video\MusicVideo,
    \NajiDev\XbmcApi\Model\Video\Season,
    \NajiDev\XbmcApi\Model\Video\TVShow;

use \NajiDev\XbmcApi\Exception\NotImplementedException;


class VideoLibrary extends AbstractService
{
	protected static $movieProperties = array(
		'director', 'streamdetails', 'runtime', 'resume', 'rating', 'set', 'year', 'setid', 'votes', 'tagline',
		'writer', 'plotoutline', 'sorttitle', 'imdbnumber', 'studio', 'showlink', 'genre', 'productioncode', 'country',
		'premiered', 'originaltitle', 'cast', 'mpaa', 'top250', 'trailer',

		'plot', 'lastplayed', 'file',

		'title',

		'playcount',

		'fanart', 'thumbnail',
	);

	protected static $episodeProperties = array(
		'director', 'streamdetails', 'runtime', 'resume', 'rating', 'tvshowid', 'votes', 'episode', 'productioncode',
		'season', 'writer', 'originaltitle', 'cast', 'firstaired', 'showtitle',

		'plot', 'lastplayed', 'file',

		'title',

		'playcount',

		'fanart', 'thumbnail',
	);

	protected static $tvshowProperties = array(
		'episodeguide', 'episode', 'imdbnumber', 'rating', 'mpaa', 'year', 'votes', 'premiered', 'originaltitle',
		'cast', 'studio', 'sorttitle', 'genre',

		'plot', 'lastplayed', 'file',

		'title',

		'playcount',

		'fanart', 'thumbnail'
	);

	protected static $seasonProperties = array(
		'season', 'tvshowid', 'episode', 'showtitle',

		'playcount',

		'fanart', 'thumbnail'
	);

	/**
	 * Cleans the video library from non-existent items
	 *
	 * @return boolean whether scanning was started
	 */
	public function clean()
	{
		return 'OK' === $this->callXbmc('Clean');
	}

	/**
	 * Exports all items from the video library
	 * @throws NotImplementedException
	 */
	public function export()
	{
		throw new NotImplementedException;
	}

	/**
	 * Retrieve details about a specific tv show episode
	 *
	 * @param $episodeId
	 * @return \NajiDev\XbmcApi\Model\Video\Episode
	 */
	public function getEpisode($episodeId)
	{
		if (null !== $episode= $this->identityMap->get('NajiDev\XbmcApi\Model\Video\Episode', $episodeId))
			return $episode;

		$response = $this->callXbmc('GetEpisodeDetails', array(
			'episodeid'  => $episodeId,
			'properties' => self::$episodeProperties
		));

		$episode = $this->buildEpisode($response->episodedetails);
		$this->identityMap->add($episode);
		return $episode;
	}

	/**
	 * Retrieve all tv show episodes
	 *
	 * @param int $tvshowid
	 * @param int $season
	 * @return \NajiDev\XbmcApi\Model\Video\Episode[]
	 */
	public function getEpisodes($tvshowid = null, $season = null)
	{
		$params = array(
			'properties' => self::$episodeProperties
		);

		if (is_int($tvshowid))
			$params['tvshowid'] = $tvshowid;
		if (is_int($season))
			$params['season'] = $season;

		$response = $this->callXbmc('GetEpisodes', $params);

		$episodes = array();
		foreach ($response->episodes as $episode)
		{
			$episode = $this->buildEpisode($episode);
			$this->identityMap->add($episode);
			$episodes[] = $episode;
		}

		return $episodes;
	}

	public function getGenres()
	{
		throw new NotImplementedException;
	}

	/**
	 * @param $movieId
	 * @return Movie
	 */
	public function getMovieDetails($movieId)
	{
		$response = $this->callXbmc('GetMovieDetails', array(
			'movieid'    => $movieId,
			'properties' => self::$movieProperties
		));

		return new Movie($response->moviedetails);
	}

	/**
	 * @param $setid
	 * @throws \NajiDev\XbmcApi\Exception\NotImplementedException
	 * @return MovieSet
	 */
	public function getMovieSet($setid)
	{
		throw new NotImplementedException;
	}

	/**
	 * @throws \NajiDev\XbmcApi\Exception\NotImplementedException
	 * @return MovieSet[]
	 */
	public function getMovieSets()
	{
		throw new NotImplementedException;
	}


	/**
	 * Retrieve all movies
	 *
	 * @return Movie[]
	 */
	public function getMovies()
	{
		$response = $this->callXbmc('GetMovies', array(
			'properties' => self::$movieProperties
		));

		$movies = array();
		foreach ($response->movies as $movie)
			$movies[] = new Movie($movie);

		return $movies;
	}

	/**
	 * Retrieve details about a specific music video
	 *
	 * @throws NotImplementedException
	 */
	public function getMusicVideoDetails()
	{
		throw new NotImplementedException;
	}

	/**
	 * Retrieve all music videos
	 *
	 * @throws NotImplementedException
	 */
	public function getMusicVideos()
	{
		throw new NotImplementedException;
	}

	/**
	 * Retrieve all recently added tv episodes
	 *
	 * @return Episode[]
	 */
	public function getRecentlyAddedEpisodes()
	{
		$response = $this->callXbmc('GetRecentlyAddedEpisodes', array(
			'properties' => self::$episodeProperties
		));

		$episodes = array();
		foreach ($response->episodes as $episode)
		{
			$episode = $this->buildEpisode($episode);
			$this->identityMap->add($episode);
			$episodes[] = $episode;
		}

		return $episodes;
	}

	/**
	 * Retrieve all recently added movies
	 *
	 * @throws \NajiDev\XbmcApi\Exception\NotImplementedException
	 * @return Movie[]
	 */
	public function getRecentlyAddedMovies()
	{
		throw new NotImplementedException;
	}

	/**
	 * Retrieve all recently added music videos
	 *
	 * @throws \NajiDev\XbmcApi\Exception\NotImplementedException
	 * @return MusicVideo[]
	 */
	public function getRecentlyAddedMusicVideos()
	{
		throw new NotImplementedException;
	}

	/**
	 * Retrieve all tv seasons
	 *
	 * @param int $tvshowid
	 * @return Season[]
	 */
	public function getSeasons($tvshowid)
	{
		$response = $this->callXbmc('GetSeasons', array(
			'tvshowid'   => $tvshowid,
			'properties' => self::$seasonProperties
		));

		$service = $this;
		$seasons = array();
		foreach ($response->seasons as $season)
		{
			$seasonObj = new Season($season);
			$seasonObj->setTvshow(function() use ($service, $seasonObj)
			{
				return $service->getTVShow($seasonObj->getTvshowid());
			});
			$this->identityMap->add($seasonObj);
			$seasons[] = $seasonObj;
		}

		return $seasons;
	}

	/**
	 * Retrieve details about a specific tv show
	 *
	 * @param $tvshowId
	 * @throws \InvalidArgumentException
	 * @return TVShow|null
	 */
	public function getTVShow($tvshowId)
	{
		if (!is_int($tvshowId))
			throw new \InvalidArgumentException('The $tvshowid has to be an integer');

		if (null !== $show = $this->identityMap->get('NajiDev\XbmcApi\Model\Video\TVShow', $tvshowId))
			return $show;

		try
		{
			$response = $this->callXbmc('GetTVShowDetails', array(
				'tvshowid'   => $tvshowId,
				'properties' => self::$tvshowProperties
			));

			$show = $this->buildTvShow($response->tvshowdetails);
			$this->identityMap->add($show);
			return $show;
		}
		catch (\InvalidArgumentException $e)
		{
			return null;
		}
	}

	/**
	 * Retrieve all tv shows
	 *
	 * @return TVShow[]
	 */
	public function getTVShows()
	{
		$response = $this->callXbmc('GetTVShows', array(
			'properties' => self::$tvshowProperties
		));

		$shows = array();
		foreach ($response->tvshows as $show)
		{
			$showObj = $this->buildTvShow($show);
			$this->identityMap->add($showObj);
			$shows[] = $showObj;
		}

		return $shows;
	}

	/**
	 * Scans the video sources for new library items
	 *
	 * @throws \NajiDev\XbmcApi\Exception\NotImplementedException
	 */
	public function scan()
	{
		throw new NotImplementedException;
	}

	protected function buildTvShow(\stdClass $show)
	{
		$service = $this;

		$showObj = new TVShow($show);
		$id      = $showObj->getId();
		$showObj->setEpisodes(function() use ($service, $id)
		{
			return $service->getEpisodes($id);
		});
		$showObj->setSeasons(function() use ($service, $id)
		{
		 	return $service->getSeasons($id);
		});

		return $showObj;
	}

	/**
	 * @param \stdClass $episode
	 * @return \NajiDev\XbmcApi\Model\Video\Episode
	 */
	protected function buildEpisode(\stdClass $episode)
	{
		$service = $this;

		$episodeObj = new Episode($episode);
		$episodeObj->setTvshow(function() use ($service, $episodeObj)
		{
			return $service->getTVShow($episodeObj->getTvshowid());
		});

		$episodeObj->setSeason(function() use ($service, $episodeObj)
		{
			$seasons = $service->getSeasons($episodeObj->getTvshowid());

			foreach ($seasons as $season)
			{
				if ($season->getSeasonNumber() == $episodeObj->getSeasonNumber())
					return $season;
			}

			return null;
		});

		return $episodeObj;
	}
}