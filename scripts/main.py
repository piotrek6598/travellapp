from presearch import Presearch


location = input("enter location")
pages = input("enter number of desired pages")
searcher = Presearch()
resuts = searher.get_places_query(location, pages)
