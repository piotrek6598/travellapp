import json, sys
import search

def extractLink(string):
    list = string.split('"')
    return list[1]

def printPlace(place):
    if 'name' in place:
        print(place["name"])
    if 'formatted_address' in place:
        print('Address:', end = ' ')
        print(place["formatted_address"])
    if 'photos' in place and len(place["photos"]) > 0:
        str = place['photos'][0]["html_attributions"][0]
        print('Photos:', end= ' ')
        print(extractLink(str))
    if 'rating' in place:
        print('Google Maps rating:', end = ' ')
        print(place["rating"])
    print()

def goodPlace(place, tags, rating):
    if 'types' not in place:
        return False
    tagsOk = False
    if len(tags) == 0:
        tagsOk = True
    for t in tags:
        if t in place["types"]:
            tagsOk = True
    if not tagsOk:
        return False
    if 'rating' not in place:
        return False
    r = float(place["rating"])
    return r >= rating

try:
    searcher = search.Searcher()
    location = sys.argv[1]
    pages = 3
    tags = []
    rating = 0.0
    i = 2
    while i < len(sys.argv) - 2:
        tags.append(sys.argv[i])
        i += 1
    if sys.argv[i] != 'none':
        rating = float(sys.argv[i])
    i += 1
    results = int(sys.argv[i])
    text = searcher.get_places_query(location.replace("_"," "), pages)
    data = json.loads(text)
    if len(tags) == 0 and rating == 0.0:
        print('Top results:')
        i = 0
        places = len(data)
        while i < places and i < results:
            printPlace(data[i])
            i += 1
    else:
        places = len(data)
        i = 0
        good = 0
        while i < places and good < results:
            if (goodPlace(data[i], tags, rating)):
                if good == 0:
                    print('Top results:')
                good += 1
                printPlace(data[i])
            i += 1
        if good == 0:
            print('No results matching.')
    

except IndexError:
    print("not enough arguments (excepted at least 3: [location], [any number of tags] [rating] [results])")
except ValueError:
    print("invalid literal for [rating] parameter")
except KeyError:
    print("No results matching")

    
