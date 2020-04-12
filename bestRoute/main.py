import makeMatrix
import permutations
import settings
import time
import numpy as np

def printRoute(places, order):
    print('The best route is:')
    print(places[0], end='->')
    for i in range (len(order)):
        num = int(order[i])
        print(listOfLocations[num], end='->')
    print(places[0])



# This will be a place where you start and finish your journey.
origin = input('Your location: ')

# List of places you want to visit.
listOfLocations = []
listOfLocations.append(origin)
try:
    n = int(input('How many places do you want to visit? '))
except ValueError:
    print('That is not an integer!')
    exit(1)
    
if n <= 0 or n > 9:
    print('Invalid number of locations')
    exit(1)
invalid = False
for i in range (n):
    place = input('Place ' + str(i + 1) + ': ')
    if not place:
        invalid = True
    listOfLocations.append(place)

# API breaks when given an empty word, so we do not allow them.
if invalid:
    print('Invalid location(s)')
    exit(1)
    
# Creating a matrix of times for places given.
size = n + 1
matrix = np.zeros((size, size))
success = makeMatrix.makeMatrix(matrix, listOfLocations)
if not success:
    print('Invalid location(s)')
    exit(1)
    
# Calculating the best route, results are stored in global variables
# settings.bestTime and settings.bestRoute.
array = np.arange(1, size)
settings.initGlobals(n)
permutations.perms(matrix, array, n)

# Printing results.
print('This journey takes', end = ' ')
print(settings.bestTime, end = ' ')
print('minutes')
printRoute(listOfLocations, settings.bestRoute)