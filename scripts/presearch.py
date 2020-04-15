from googlemaps.exceptions import ApiError
import googlemaps
import yaml
import paths
import time


class PresearchException(Exception):
    def __init__(self, cause):
        self._cause = cause

    def __str__(self):
        return "Presearch Exception:\n" \
               "cause: " + self._cause


class Presearch:
    """
    :param: _client:            A google-api client used to perform requests
                                client docs: https://googlemaps.github.io/google-maps-services-python/docs/index.html
    :param: _query_endpoint:    Arbitrary chosen text added to the beginning of every query
    :param: _query_type:        Additional parameter crucial to narrow request results.
    :param: _next_page_delay:   Arbitrary chosen the accepted delay between retrieving pages of results.
    :param: _max_pages:         The max number of pages to retrieve per request provided by google-api
    """

    def __init__(self):
        self._client = googlemaps.Client(key=self._get_api_key())
        self._query_endpoint = "Tourist attractions in "
        self._query_type = "tourist_attraction"
        self._next_page_delay = 2.0
        self._max_pages = 3

    @staticmethod
    def _get_api_key():
        """
        Extracts api-key from config file stored in AttractionSearcher/
        :return: api-key
        """
        with open(paths.PATH_TO_CONFIG, 'r') as config_file:
            config = yaml.safe_load(config_file)
            return config['google']['api_key']

    def get_places_query(self, query, pages):
        """
        Get places via google-api
        :param query:   name of area to search attractions within
        :param pages:   number of result pages to retrieve (each contain of 20 results)
        :return: List of results
        """

        with open(paths.PATH_TO_LOGS, 'a') as logs:
            logs.write(f"time = {time.ctime()}, get_places_query() starts\n")

        response = self._client.places(
            query=self._query_endpoint + query,
            type=self._query_type,
        )

        if response['status'] != 'OK':
            raise PresearchException('Google Client request failed')

        pages = min(pages, self._max_pages)
        results = response['results']
        next_page_token = response['next_page_token']

        if next_page_token is not None and pages > 1:
            self._retrieve_next_page(results, next_page_token, 2, pages)

        with open(paths.PATH_TO_LOGS, 'a') as logs:
            logs.write(f"time = {time.ctime()}, get_places_query() ends\n")
            logs.write('\n')
        return results

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
                with open(paths.PATH_TO_LOGS, 'a') as logs:
                    logs.write(f"depth = {page}, time = {time_now}, waiting for token validation...\n")

        if processed is False:
            raise PresearchException("google-api delay too huge")


c = Presearch()
cd = c.get_places_query("warsaw", 3)
a = 1