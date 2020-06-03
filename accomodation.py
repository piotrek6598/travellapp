from selenium.webdriver import Chrome
from selenium.webdriver.chrome.options import Options
from time import sleep
import sys
import math

#sortBy polecane - 1, cena - 2, ocena - 4
#dates in format yyyy-mm-dd
#ignores noChilds

def get_hotels(place, date1, date2, noAdults, noChilds, resultSize, maxPrice, sortBy):

    from selenium.webdriver.chrome.options import Options
    options = Options()
    options.headless = True

    driver = Chrome(executable_path='/opt/chromedriver', options=options)
    trivago = 'https://www.trivago.pl'
    driver.get(trivago)

    placeElement = driver.find_element_by_xpath('//*[@id="querytext"]')
    placeElement.send_keys(place)
    sleep(0.5)
    driver.find_element_by_xpath('//*[@id="js-fullscreen-hero"]/div[1]/form/button[2]').click()

    url = driver.current_url

    index = url.find('?aDateRange%5Barr%5D=')
    url = url[:(index + 21)] + date1 + url[(index + 31):]
    #print(url)

    index = url.find('aDateRange%5Bdep%5D=')
    url = url[:(index + 20)] + date2 + url[(index + 30):]
    #print(url)

    index = url.find('&aPriceRange%5Bto%5D=')
    url = url[:(index + 21)] + str(math.floor(maxPrice * 21.9)) + url[(index + 22):]
    #print(url)

    if noAdults == 1:
        roomType = 1
    elif noAdults == 2:
        roomType = 7
    else:
        roomType = 9

    index = url.find('iRoomType=')
    url = url[:(index + 10)] + str(roomType) + url[(index + 11):]
    #print(url)


    index = url.find('adults%5D=')
    url = url[:(index + 10)] + str(noAdults) + url[(index + 11):]


    index = url.find('sortingId=')

    url = url[:(index + 10)] + str(sortBy) + url[(index + 11):]

    driver.get(url)
    sleep(8)
    hotelNames = driver.find_elements_by_xpath('//ol/li/div/article/div[1]/div[2]/div/div/h3/span')
                                              
    hotelTypes = driver.find_elements_by_xpath('//ol/li//p[@data-qa="accommodation-type"]')

    hotelPhotos = driver.find_elements_by_xpath('//ol/li/div/article/div[1]/div[1]/div[2]/div/img')
    hotelPrices = driver.find_elements_by_xpath('//ol/li/div/article/div[1]/div[2]/section/div[2]/article/div/div[2]/div/div/div/strong')
                                                
    hotelRates = driver.find_elements_by_xpath('//ol/li/div/article/div[1]/div[2]/div/div/button/span[1]/span[1]/span')

    print(url)
    print(min(resultSize, len(hotelNames), len(hotelTypes), len(hotelPrices), len(hotelNames)))
    for i in range(min(resultSize, len(hotelNames), len(hotelTypes), len(hotelPrices), len(hotelNames))):
        print(hotelNames[i].text)
        print(hotelTypes[i].text)
        if (i >= len(hotelPhotos)):
            print()
        else:
            print(hotelPhotos[i].get_attribute('src'))
        print(hotelPrices[i].text)
        print(hotelRates[i].text)

get_hotels(sys.argv[5], sys.argv[2], sys.argv[3], int(sys.argv[6]), 0, 20 ,int(sys.argv[4]), sys.argv[1])
