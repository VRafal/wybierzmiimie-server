<?php

/**
 * MVP version
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/api/v1/names', function (Request $request, Response $response) {

	$sql = "SELECT * FROM `names-and-all-quantity`";
	return getResponseBySQLQuery($sql, $response);
});

$app->get('/api/v1/statistic', function (Request $request, Response $response) {

	$sql = "SELECT * FROM `statistic-and-names`";
	return getResponseBySQLQuery($sql, $response);
});

function getResponseBySQLQuery(string $sql, Response $response)
{
	try {
		$db = new db();
		$db = $db->connect();

		$stmt = $db->query($sql);
		$data = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		$dataJSON = json_encode($data, JSON_FORCE_OBJECT);
		if (json_last_error_msg() === "No error") {
			setSuccessResponse($dataJSON, $response);
		} else {
			setErrorResponse(500, "JSON encode problem: " . json_last_error_msg(), $response);
		}
	} catch (PDOException $e) {
		setErrorResponse(500, $e->getMessage(), $response);
	}
	
	$response = $response->withHeader('Content-Type', 'application/json');
	$response = $response->withHeader('Access-Control-Allow-Origin', '*');
	return $response;
}

function setSuccessResponse(string $dataJSON, Response $response)
{
	$response->getBody()->write('{"status": 200, "message": "OK", "data": ' . $dataJSON . ', "data-version": "' . $_ENV['DATA_VERSION'] . '" }');
}

function setErrorResponse(int $status, string $message, Response $response)
{
	$response->getBody()->write('{"status": ' . $status . ', "message": "' . $message . '"}');
}
