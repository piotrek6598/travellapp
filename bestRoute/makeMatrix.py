import distance

# Given a matrix filled with zeros and list of locations, creates a matrix of times.
# Value stored at matrix[i][j] represents time (in minutes)
# needed to get from i-th to j-th location.
# Location No. 0 is a starting location.
# Result depending on success of the operation.
def makeMatrix(matrix, places):
    if not places:
        return False
    rows = len(matrix)
    cols = len(matrix[0])
    if rows != len(places):
        return False
    if cols != len(places):
        return False
    for i in range (rows):
        for j in range (cols):
            if i != j:
                dist = distance.distance(places[i], places[j])
                if dist < 0:
                    return False
                matrix[i][j] = dist
  
    return True