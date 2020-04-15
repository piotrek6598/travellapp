from search import Searcher
import sys


try:
    location = sys.argv[1]  # first param - [0] is an executed path
    pages = int(sys.argv[2])

    searcher = Searcher()
    resuts = searcher.get_places_query(location, pages)

except IndexError:
    print("not enough arguments (excepted 2: [location], [pages])")
except ValueError:
    print("invalid literal for [pages] parameter")