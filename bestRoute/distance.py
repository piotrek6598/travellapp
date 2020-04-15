import googlemaps, json

# Converts seconds to minutes (rounding to integers)
def toMinutes(secs):
    if (secs < 0):
        return -1;
    res = secs // 60
    if(secs % 60 >= 30):
        res += 1
    return res

# Calculates how much time (in minutes) we need to get from source to destination,
# using Google Distance Matrix API. Returns -1 if any of locations is invalid.
def distance(source, destination):
    gmaps = googlemaps.Client(key='########################')
    x = gmaps.distance_matrix(source, destination)
    if 'rows' not in x:
        return -1
    if not x["rows"]:
        return -1
    if 'elements' not in x["rows"][0]:
        return -1
    if not x["rows"][0]["elements"]:
        return -1
    if 'duration' not in x["rows"][0]["elements"][0]:
        return -1
    if 'value' not in x["rows"][0]["elements"][0]["duration"]:
        return -1
    time = (x["rows"][0]["elements"][0]["duration"]["value"])
    return toMinutes(time)

