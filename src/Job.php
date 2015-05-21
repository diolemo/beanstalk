<?php
/**
 * beanstalk: A minimalistic PHP beanstalk client.
 *
 * Copyright (c) 2009-2015 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 */

namespace Beanstalk;

class Job {

	public $id;
	public $body;

	protected $_client;

	public function __construct($client)
	{
		$this->_client = $client;
	}

	/**
	 * Puts the job into the `buried` state Buried jobs are put into a FIFO
	 * linked list and will not be touched until a client kicks them.
	 *
	 * @param integer $pri *New* priority to assign to the job.
	 * @return boolean `false` on error, `true` on success.
	 */
	public function bury($pri = 0)
	{
		return $this->_client->bury($this->id, $pri);
	}

	/**
	 * Allows a worker to request more time to work on a job.
	 *
	 * @return boolean `false` on error, `true` on success.
	 */
	public function touch()
	{
		return $this->_client->touch($this->id);
	}

	/**
	 * Gives statistical information about the specified job if it exists.
	 *
	 * @return string|boolean `false` on error otherwise a string with a yaml formatted dictionary.
	 */
	public function stats()
	{
		return $this->_client->statsJob($this->id);
	}

	/**
	 * Puts a reserved job back into the ready queue.
	 *
	 * @param integer $pri Priority to assign to the job.
	 * @param integer $delay Number of seconds to wait before putting the job in the ready queue.
	 * @return boolean `false` on error, `true` on success.
	 */
	public function release($pri = 0, $delay = 0)
	{
		return $this->_client->release($this->id, $pri, $delay);
	}

	/**
	 * Removes a job from the server entirely.
	 *
	 * @return boolean `false` on error, `true` on success.
	 */
	public function delete()
	{
		return $this->_client->delete($this->id);
	}

}

?>