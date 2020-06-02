import requests
import sys
import json
import pycountry
from translate import Translator

def concatArgs():
    i = 1
    total = len(sys.argv)
    result = ''
    while i < total:
        result += sys.argv[i]
        if i < total - 1:
            result += '+'
        i += 1
    return result

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
    if "sys" not in weather:
        return -1
    if "country" not in weather["sys"]:
        return -1
    if "wind" not in weather:
        return -1
    if "speed" not in weather["wind"]:
        return -1
    print (weather["weather"][0]["main"])
    print (weather["weather"][0]["description"])
    print (toCelsius(weather["main"]["temp"]))
    print (weather["wind"]["speed"])
    #country = pycountry.countries.get(alpha_2 = weather["sys"]["country"]).name
    #translator= Translator(to_lang="pl")
    #print(translator.translate(country))
    print(weather["sys"]["country"])
    return 0

# My API key.
key = '0c57e9cadf598213edf8bb3ab57dba93'

if (len(sys.argv) < 2):
    print('Usage: ' + sys.argv[0] + ' place')
    exit(1)
    
part1 = 'http://api.openweathermap.org/data/2.5/weather?q='
part2 = concatArgs()
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