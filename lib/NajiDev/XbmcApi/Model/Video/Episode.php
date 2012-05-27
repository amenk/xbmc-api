<?php

namespace NajiDev\XbmcApi\Model\Video;

use \NajiDev\XbmcApi\Model\Video\Cast;


class Episode extends File
{
	/**
	 * @var float
	 */
	protected $raiting;

	/**
	 * @var int
	 */
	protected $tvshowid;

	/**
	 * @var string
	 */
	protected $votes;

	/**
	 * @var int
	 */
	protected $episode;

	/**
	 * @var string
	 */
	protected $productioncode;

	/**
	 * @var int
	 */
	protected $season;

	/**
	 * @var string
	 */
	protected $writer;

	/**
	 * @var string
	 */
	protected $originaltitle;

	/**
	 * @var Cast[]
	 */
	protected $cast = array();

	/**
	 * @var string
	 */
	protected $firstaired;

	/**
	 * @var string
	 */
	protected $showtitle;

	public function __construct($object = null)
	{
		parent::__construct($object);

		if ($object instanceof \stdClass)
		{
			$this->id = $object->episodeid;

			$this->setRaiting($object->rating);
			$this->setTvshowid($object->tvshowid);
			$this->setVotes($object->votes);
			$this->setEpisode($object->episode);
			$this->setProductioncode($object->productioncode);
			$this->setSeason($object->season);
			$this->setWriter($object->writer);
			$this->setOriginaltitle($object->originaltitle);
			$this->setCast($object->cast);
			$this->setFirstaired($object->firstaired);
			$this->setShowtitle($object->showtitle);

			$casts = array();
			foreach ($object->cast as $cast)
				$casts[] = new Cast($cast);
			$this->setCast($casts);
		}
	}

	public function setCast($cast)
	{
		$this->cast = $cast;
	}

	/**
	 * @return \NajiDev\XbmcApi\DataType\Video\Cast[]
	 */
	public function getCast()
	{
		return $this->cast;
	}

	/**
	 * @param int $episode
	 */
	public function setEpisode($episode)
	{
		$this->episode = $episode;
	}

	/**
	 * @return int
	 */
	public function getEpisode()
	{
		return $this->episode;
	}

	/**
	 * @param string $firstaired
	 */
	public function setFirstaired($firstaired)
	{
		$this->firstaired = $firstaired;
	}

	/**
	 * @return string
	 */
	public function getFirstaired()
	{
		return $this->firstaired;
	}

	/**
	 * @param string $originaltitle
	 */
	public function setOriginaltitle($originaltitle)
	{
		$this->originaltitle = $originaltitle;
	}

	/**
	 * @return string
	 */
	public function getOriginaltitle()
	{
		return $this->originaltitle;
	}

	/**
	 * @param string $productioncode
	 */
	public function setProductioncode($productioncode)
	{
		$this->productioncode = $productioncode;
	}

	/**
	 * @return string
	 */
	public function getProductioncode()
	{
		return $this->productioncode;
	}

	/**
	 * @param float $raiting
	 */
	public function setRaiting($raiting)
	{
		$this->raiting = $raiting;
	}

	/**
	 * @return float
	 */
	public function getRaiting()
	{
		return $this->raiting;
	}

	/**
	 * @param int $season
	 */
	public function setSeason($season)
	{
		$this->season = $season;
	}

	/**
	 * @return int
	 */
	public function getSeason()
	{
		return $this->season;
	}

	/**
	 * @param string $showtitle
	 */
	public function setShowtitle($showtitle)
	{
		$this->showtitle = $showtitle;
	}

	/**
	 * @return string
	 */
	public function getShowtitle()
	{
		return $this->showtitle;
	}

	/**
	 * @param int $tvshowid
	 */
	public function setTvshowid($tvshowid)
	{
		$this->tvshowid = $tvshowid;
	}

	/**
	 * @return int
	 */
	public function getTvshowid()
	{
		return $this->tvshowid;
	}

	/**
	 * @param string $votes
	 */
	public function setVotes($votes)
	{
		$this->votes = $votes;
	}

	/**
	 * @return string
	 */
	public function getVotes()
	{
		return $this->votes;
	}

	/**
	 * @param string $writer
	 */
	public function setWriter($writer)
	{
		$this->writer = $writer;
	}

	/**
	 * @return string
	 */
	public function getWriter()
	{
		return $this->writer;
	}
}