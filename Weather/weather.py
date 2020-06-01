import requests
import sys
import json

def toCelsius(temp):
    try:
        kelvin = float(temp)
        kelvinRound = round(kelvin)
        return kelvinRound - 273
    except ValueError:
        exit(1)

def getWeather(weather):
    if not weather:
        return -1
    if "weather" not in weather:
        return -1
    if len(weather["weather"]) < 1:
        return -1
    if "main" not in weather["weather"][0]:
        return -1
    if "description" not in weather["weather"][0]:
        return -1
    if "main" not in weather:
        return -1
    if "temp" not in weather["main"]:
        return -1
    print (weather["weather"][0]["main"])
    print (weather["weather"][0]["description"])
    print (toCelsius(weather["main"]["temp"]))
    return 0

# My API key.
key = '0c57e9cadf598213edf8bb3ab57dba93'

if (len(sys.argv) < 2):
    print('Usage: ' + sys.argv[0] + ' place')
    exit(1)

part1 = 'http://api.openweathermap.org/data/2.5/weather?q='
part2 = sys.argv[1]
part3 = '&APPID='
part4 = key
request = part1 + part2 + part3 + part4
response = requests.get(request)
if not response:
    print('Weather not found')
    exit(1)
    
weather = json.loads(response.text)
if (getWeather(weather) < 0):
    exit(1)