<?php
	namespace Elemeno;

	use GuzzleHttp\Client as GuzzleHttpClient;
	use GuzzleHttp\Exception\TransferException as GuzzleHttpTransferException;

	class Client {
		function __construct($apiKey)
		{
			$this->httpClient = new GuzzleHttpClient();
			$this->apiKey = $apiKey;
			$this->baseUrl = 'https://api.elemeno.io/v1/';
			$this->singleBase = 'singles/';
			$this->collectionBase = 'collections/';
			$this->genericError = (object) [
				'status' => 'error',
				'error' => (object) [
					'message' => 'Something went wrong'
				]
			];
		}

		private function get($path, $query = null) {
			$options = [
				'headers' => [
					'Authorization' => $this->apiKey
				]
			];

			if (is_array($query)) {
				$options['query'] = $query;
			}

			try {
				$res = $this->httpClient->request('GET', $this->baseUrl . $path, $options);

				return json_decode($res->getBody());
			}
			catch (GuzzleHttpTransferException $e) {
				if ($e->hasResponse()) {
					$res = $e->getResponse();

					$decoded = json_decode($res->getBody());

					return $decoded ? $decoded : $this->genericError;
				}
				else {
					return $this->genericError;
				}
			}
		}

		private function getQuery($options = null, $allow = false) {
			$query = [];

			if ($options && is_array($options)) {
				if (array_key_exists('filters', $options) && is_array($allow) && in_array('filters', $allow)) {
					$query['filters'] = json_encode($options['filters']);
				}
				if (array_key_exists('sort', $options) && is_array($allow) && in_array('sort', $allow)) {
					$query['sort'] = json_encode($options['sort']);
				}
				if (array_key_exists('page', $options)) {
					$query['page'] = json_encode($options['page']);
				}
				if (array_key_exists('size', $options)) {
					$query['size'] = json_encode($options['size']);
				}
				if (array_key_exists('byId', $options)) {
					$query['byId'] = ($options['byId'] === true || $options['byId'] === 'true') ? true : false;
				}
			}

			return $query;
		}

		function getSingles($options = null) {
			return $this->get($this->singleBase, $this->getQuery($options, ['sort']));
		}

		function getSingle($singleSlug) {
			return $this->get($this->singleBase . $singleSlug);
		}

		function getCollections($options = null) {
			return $this->get($this->collectionBase, $this->getQuery($options, ['sort']));
		}

		function getCollection($collectionSlug) {
			return $this->get($this->collectionBase . $collectionSlug);
		}

		function getCollectionItems($collectionSlug, $options = null) {
			return $this->get($this->collectionBase . $collectionSlug . '/items', $this->getQuery($options, ['filters', 'sort']));
		}

		function getCollectionItem($collectionSlug, $itemSlug, $options = null) {
			return $this->get($this->collectionBase . $collectionSlug . '/items/' . $itemSlug, $this->getQuery($options, ['sort']));
		}
	}
?>
