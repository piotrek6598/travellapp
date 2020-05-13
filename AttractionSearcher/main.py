import json, sys
import search

def printPlace(searcher, place):
    if 'name' not in place:
        exit(1)
    print(place["name"])
    if 'formatted_address' not in place:
        exit(1)
    print('Address:', end = ' ')
    print(place["formatted_address"])
    if 'photos' in place:
        photo_ref = place['photos'][0]
        if photo_ref:
            place['photos'] = [searcher._get_photo(photo_ref)]
            print(place['photos'][0]);
        else:
            place['photos'] = []
    if 'rating' not in place:
        exit(1)
    print('Google Maps rating:', end = ' ')
    print(place["rating"])

def goodPlace(place, tags, rating):
    if 'types' not in place:
        exit(1)
    tagsOk = False
    if len(tags) == 0:
        tagsOk = True
    for t in tags:
        if t in place["types"]:
            tagsOk = True
    if not tagsOk:
        return False
    if 'rating' not in place:
        exit(1)
    r = float(place["rating"])
    return r >= rating

try:
    searcher = search.Searcher()
    location = sys.argv[1]
    pages = 1
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
            printPlace(searcher, data[i])
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
                printPlace(searcher, data[i])
            i += 1
        if good == 0:
            print('No results matching.')
            exit(1)
    

except IndexError:
    print("not enough arguments (excepted at least 3: [location], [any number of tags] [rating] [results])")
    exit(1)
except ValueError:
    print("invalid literal for [rating] or [results] parameter")
    exit(1)
except KeyError:
    print("No results matching.")
    exit(1)

    
