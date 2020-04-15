from googlemaps.exceptions import ApiError
from pathlib import Path
import googlemaps
import json
import yaml
import time
import os
import sys


class SearchException(Exception):
    def __init__(self, cause):
        self._cause = cause

    def __str__(self):
        return "Search Exception:\n" \
               "cause: " + self._cause


class Searcher:
    """
    :param: _client:            A google-api client used to perform requests.
                                Client docs: https://googlemaps.github.io/google-maps-services-python/docs/index.html
    :param: _query_endpoint:    Arbitrary chosen text added to the beginning of every query.
    :param: _query_type:        Additional parameter crucial to narrow request results.
    :param: _next_page_delay:   Arbitrary chosen the accepted delay between retrieving pages of results.
    :param: _max_pages:         The max number of pages to retrieve per request provided by google-api.
    :param: _basedir_path:      Path to the project directory.
    :param: _config_path:       Path to the config directory.
    :param: _logs_path:         Path to the logs directory.
    :param: _max_width:         Max width of photos related to results (in pixels)
    :param: _photo_endpoint:    Base endpoint for photo requests.

    """

    def __init__(self):
        self._basedir_path = str(Path(__file__).parent.absolute())
        self._config_path = os.path.join(self._basedir_path, 'config.yml')
        self._logs_path = os.path.join(self._basedir_path, 'logs.txt')
        self._client = googlemaps.Client(key=self._get_api_key())
        self._query_endpoint = "Tourist attractions in "
        self._photo_endpoint = 'https://maps.googleapis.com/maps/api/place/photo'
        self._query_type = "tourist_attraction"
        self._next_page_delay = 2.0
        self._max_pages = 3
        self._max_width = 1080

    def _get_api_key(self):
        """
        Extracts api-key from config file stored in AttractionSearcher/
        :return: api-key
        """
        with open(self._config_path, 'r') as config_file:
            config = yaml.safe_load(config_file)
            return config['google']['api_key']

    def get_places_query(self, query, page_num):
        """
        Get places via google-api
        :param query:        name of area to search attractions within
        :param page_num:     number of result pages to retrieve (each contain of 20 results)
        :return: List of results
        """

        with open(self._logs_path, 'a') as logs:
            logs.write(f"time = {time.ctime()}, get_places_query() starts\n")

        response = self._client.places(
            query=self._query_endpoint + query,
            type=self._query_type,
        )

        if response['status'] != 'OK':
            raise SearchException('Google Client request failed')

        page_num = min(int(page_num), int(self._max_pages))
        results = response['results']
        next_page_token = response['next_page_token']

        if next_page_token is not None and page_num > 1:
            self._retrieve_next_page(results, next_page_token, 2, page_num)

        for res in results:
            photo_ref = res['photos'][0] if 'photos' in res else None
            if photo_ref is not None:  # replaces photo reference by a photo file. Field remains singleton-list.
                res['photos'] = [self._get_photo(photo_ref)]
            else:
                res['photos'] = []

        with open(self._logs_path, 'a') as logs:
            logs.write(f"time = {time.ctime()}, get_places_query() ends\n")
            logs.write('\n')

        return json.dumps(results)

    def _retrieve_next_page(self, results, token, page, max_page):
        """
        Add next page of results to the passed result-list
        Note: next_page_token becomes valid after a short delay.
        :param results:   list where to add results
        :param token:     next_page_token from previous request
        :param page:      number of retrieving page (numbered from 1, max 3)
        :param max_page:  max recursion depth
        """

        loop_start_time = time.time()
        time_now = time.time()
        processed = False              # if the next page was yet processed

        while time_now - loop_start_time < self._next_page_delay and processed is False:
            try:
                next_page = self._client.places(
                    query='ignored_param',
                    type='ignored_param',
                    page_token=token,
                )

                processed = True
                next_page_results = next_page['results']
                next_page_token = next_page['next_page_token'] if 'next_page_token' in next_page else None
                results += next_page_results

                if page < max_page and next_page_token is not None:
                    self._retrieve_next_page(results, next_page_token, page + 1, max_page)

            except ApiError:
                time_now = time.time()
                with open(self._logs_path, 'a') as logs:
                    logs.write(f"depth = {page}, time = {time_now}, waiting for token validation...\n")

        if processed is False:
            raise SearchException("google-api delay too huge")

    def _get_photo(self, reference):
        """
        Creates photo url
        :param reference:  Photo reference obtained from places-api' response
        :return:           Url, which is google-api request
        """
        ref = reference['photo_reference']
        return f'{self._photo_endpoint}?maxwidth={self._max_width}&photoreference={ref}&key={self._get_api_key()}'

