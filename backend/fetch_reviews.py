"""
This script fetches the appid, reviews and rating of each review
"""
import sys
reload(sys)
sys.setdefaultencoding('utf-8')  # Sets the encoding for nepali
import requests
from bs4 import BeautifulSoup

with open('appids.txt') as file:
    data = file.read()

list = data.splitlines()

# playurl = 'https://play.google.com/store/apps/details?id=com.facebook.katana'
for playurl in list:
    # Find app id
    pos = playurl.find('id=')
    appid = playurl[pos + 3:]

    # Get the file
    r = requests.get(playurl)
    content = r.content

    # Prepares the source
    soup = BeautifulSoup(content, "lxml")

    ratings = []
    stars = soup.findAll(
        'div', {'class': 'tiny-star star-rating-non-editable-container'})
    for s in stars:
        star = str(s.get("aria-label"))
        star = star.replace("Rated ",'').replace(' stars out of five stars','')
        ratings.append(star)
    print ratings
    fobj = open('ratings.csv', 'a')
    for l in ratings:
        fobj.write('"'+appid+'","'+l+'"\n')
    fobj.close()

    # # Comments
    # commentlist = []
    # comments = soup.findAll('div', {'class': 'review-body'})
    # for comment in comments:
    #     unfiltered = comment.text
    #     filter = unfiltered.replace("Full Review", "").replace('"','').lower()
    #     print filter
    #     commentlist.append(filter)

    # # print len(commentlist)
    # fobj = open('comments.csv', 'a')
    # for l in commentlist:
    #     fobj.write('"'+appid+'","'+l+'"\n')
    #     # fobj.write(l)
    # fobj.close()

    # Star
