<?php 
namespace App\Classes;

interface ApiResponseInterface
{
	/**
   * Response success
   * @var integer
   */
  const OK = 200;

  /**
   * Response data has been created
   * @var integer
   */
  const CREATED = 201;

  /**
   * Response for bad request
   * @var integer
   */
  const BAD_REQUEST = 400;

  /**
   * Response for not found data or other
   * @var integer
   */
  const NOT_FOUND = 404;

  /**
   * Response for forbidden access
   * @var integer
   */
  const FORBIDDEN = 403;

  /**
   * Response for not completed request from user
   * @var integer
   */
  const UNPROCESSEBLE_ENTITY = 422;

  /**
   * Response for internal server error
   * @var integer
   */
  const SERVER_ERROR = 500;

  /**
   * Response for server unavailable
   * @var integer
   */
  const SERVER_UNAVAILABLE = 503;

  /**
   * Response for unauthorized
   */
  const UNAUTHORIZED = 401;
}
