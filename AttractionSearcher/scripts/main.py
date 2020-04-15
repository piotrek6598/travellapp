from presearch import Presearch
import sys


try:
    location = sys.argv[1]  # first param - [0] is an executed path
    pages = sys.argv[2]
    searcher = Presearch()
    resuts = searcher.get_places_query(location, pages)
except IndexError:
    print("not enough arguments (excepted 2: location, pages)")