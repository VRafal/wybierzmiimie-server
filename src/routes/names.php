<?php

/**
 * MVP version
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/api/v1/names', function (Request $request, Response $response) {

	$sql = "SELECT * FROM `names-and-all-quantity2`";
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
		$names = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		$response->getBody()->write('{"status": 200, "message": "OK", "data": ' . json_encode($names) . ', "data-version": "' . $_ENV['DATA_VERSION'] . '" }');
	} catch (PDOException $e) {
		$response->getBody()->write('{"status": 500, "message": "' . $e->getMessage() . '"}');
	}

	return $response;
}
