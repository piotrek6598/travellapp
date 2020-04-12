import numpy as np

def initGlobals(size):
    global bestTime
    bestTime = -1
    global bestRoute
    bestRoute = np.zeros(size)