from selenium.webdriver import Chrome
from selenium.webdriver.chrome.options import Options
import sys
from time import sleep


def get_safety(place):
    options = Options()
    options.headless = True

    driver = Chrome(executable_path='/home/piotr/chromedriver', options=options)
    gov = 'https://www.gov.pl/web/dyplomacja/'
    gov = gov + place
    driver.get(gov)
    warning = driver.find_element_by_xpath('/html/body/main/div[2]/article/div[1]/div')
    content = warning.get_attribute('innerHTML')
    print(content)
    
get_safety(sys.argv[1])