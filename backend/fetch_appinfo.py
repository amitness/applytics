"""
Fetch the important information of the app.
"""

import requests
from bs4 import BeautifulSoup

import sys
reload(sys)
sys.setdefaultencoding('utf-8')  # Sets the encoding for nepali

# Read the appids from file
with open('appids.txt') as file:
    f = file.read()

appids = f.splitlines()

# Create headers for csv
ofile = open('appdata.csv', 'a')
ofile.write('appname,appid,icon url,category,last update,average rating,people count,rating one,rating two,rating three,rating four,rating five,website url,email,downloads,price\n')
ofile.close()

# appurl = 'https://play.google.com/store/apps/details?id=com.facebook.katana'

for appurl in appids:
    # Fetch the source
    r = requests.get(appurl)
    content = r.content

    soup = BeautifulSoup(content, "lxml")

    # Find app id
    pos = appurl.find('id=')
    appid = appurl[pos + 3:]

    # App name
    appname = soup.find('div', {'class': 'id-app-title'}).text
    print appname

    # App Icon
    icon = soup.find('img', {'class': 'cover-image'})
    iconsrc = icon.get('src')

    # Find Category
    category = soup.find('span', {'itemprop': 'genre'}).text
    print category

    # Last updated timestamp
    lastupdate = soup.find('div', {'itemprop': 'datePublished'}).text
    print lastupdate

    # App rating
    averagerating = soup.find('div', {'class': 'score'}).text
    print averagerating

    # Total people rating it
    peoplecount = soup.find('span', {'class': 'reviews-num'}).text
    print peoplecount

    # 1,2,3,4,5 star count
    ratings = soup.findAll('span', {'class': 'bar-number'})
    ratingone = ratings[0].text.replace(",","")
    ratingtwo = ratings[1].text.replace(",","")
    ratingthree = ratings[2].text.replace(",","")
    ratingfour = ratings[3].text.replace(",","")
    ratingfive = ratings[4].text.replace(",","")

    # Developer Website
    linkdivs = soup.findAll('a', {'class': 'dev-link'})
    redirecturl = linkdivs[0].get("href")
    urlpos = redirecturl.find("?q=")
    websiteurl = redirecturl[urlpos + 3:]
    print websiteurl

    # Developer Email
    url = linkdivs[1].get("href")
    urlpos = url.find("mailto:")
    email = url[urlpos + 7:]
    print email

    # Total Downloads
    downloads = soup.find('div', {'itemprop': 'numDownloads'}).text.strip()
    print downloads

    # Price of the App
    buttontext = soup.find(
        'button', {'class': 'price buy id-track-click'}).text
    if "$" in buttontext:
        price = buttontext.strip().replace(' Buy', '').replace('$', '')
    else:
        price = "0"
    print price

    ofile = open('appdata.csv', 'a')
    ofile.write('"'+appname+'","'+appid+'","'+iconsrc+'","'+category+'","'+lastupdate+'",'+averagerating+',"'+peoplecount+'",'+ratingone+','+ratingtwo+','+ratingthree+','+ratingfour+','+ratingfive+',"'+websiteurl+'","'+email+'","'+downloads+'",'+price+'\n')
    ofile.close()
