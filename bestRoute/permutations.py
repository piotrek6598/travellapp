import numpy as np
import settings

def swap(array, x, y):
    temp = array[x]
    array[x] = array[y]
    array[y] = temp
    
def setBestRoute(array):
    l = len(array)
    for i in range (l):
        settings.bestRoute[i] = array[i]

# Calculates a total time of journey.
# Matrix is a matrix of time distances.
# Array represents the order in which we visit locations.
# For example, for array [2, 1, 3] our route is:
# 0->2->1->3->0 (we always start and finish in 0)
def totalTime(matrix, array):
    result = 0
    act = 0
    next = array[0]
    size = len(array)
    for i in range (size):
        result += matrix[act][next]
        act = next
        if i < size - 1:
            next = array[i + 1]
        else:
            next = 0
    result += matrix[act][0]
    return int(result)

# Iterates over all permutations of array using Heap's algorithm.
# For each permutations calculates the length of journey using matrix and
# totalTime function. Best route and its time are stored in global variables
# from settings.py.
def perms(matrix, array, k):
    if k == 1:
        t = totalTime(matrix, array)
        if settings.bestTime == -1 or settings.bestTime > t:
            settings.bestTime = t
            setBestRoute(array)
    else:
        perms(matrix, array, k - 1)
        for i in range (k - 1):
            if k % 2 == 0:
                swap(array, i, k - 1)
            else:
                swap(array, 0, k - 1)
            perms(matrix, array, k - 1)


