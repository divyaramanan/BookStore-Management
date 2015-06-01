#!C:\Python34\python.exe
'''
The First part of the document uploads the file into tmpMedia by getting the fields from the form
Next the image is converted into thumbnail of size 128 * 128 or according to the aspect ratio which depends on user's input.
Next the uploaded image is taken,resized and the title is written on the top considering the word wrap
Image filters like emboss,blur,edge detection,enhance more are applied
Image is watermarked with "Azteka"
Exif data is fetched and is stored in exif_isbnnumber.txt
'''
import os,cgi
from PIL import Image
from PIL import ImageFont
from PIL import ImageDraw
from PIL import ImageOps
from PIL.ExifTags import TAGS
from PIL import ImageFilter,ImageEnhance
from math import atan, degrees
import cgitb; cgitb.enable()
import textwrap

print ("Content-type: text/html\r\n\r\n")

form = cgi.FieldStorage()

# A nested FieldStorage instance holds the file
fileitem = form['img']
isbn = form.getvalue('isbn')
title = form.getvalue('title')
author = form.getvalue('author')
fname = isbn+".jpg"
ratio = form.getvalue('ratio')

# Test if the file was uploaded
if fileitem.filename:
   
   # strip leading path from file name to avoid directory traversal attacks
   fn = os.path.basename(fname)
   open('tmpmedia/' + fn, 'wb').write(fileitem.file.read())
   message = 'The file "' + fname + '" was uploaded successfully'
   
else:
   message = 'No file was uploaded'
   
   
print ("<html><head><title>Hello World from Python</title></head><body>%s</body></html>",message)
#THUMBNAIL GENERATION
size = 128, 128
resize = 340,510
im = Image.open("tmpmedia/" + fname)
if ratio == "no":
	width, height = im.size
	if width > height:
		delta = width - height
		left = int(delta/2)
		upper = 0
		right = height + left
		lower = height
	else:
		delta = height - width
		left = 0
		upper = int(delta/2)
		right = width
		lower = width + upper
	im = im.crop((left, upper, right, lower))
im.thumbnail(size)
im.save("thumbnail/" + fname)

#TEASER GENERATION
im = Image.open("tmpmedia/" + fname)
font_size = 30
teaser_text = "\'"+title+"\' by "+author
font = ImageFont.truetype("bootstrap/fonts/Diavlo.otf",font_size)
im = im.resize(resize, Image.ANTIALIAS)
draw = ImageDraw.Draw(im)
lines = textwrap.wrap(teaser_text, width = 15)
y_text = 20
for line in lines:
    draw.text((20,y_text), line, font = font, fill = (255, 255,0))
    y_text += font_size
draw = ImageDraw.Draw(im)
im.save("teaser/" + fname)

#BLUR,ENHANCE MORE,EMBOSS,EDGE DETECTION
im = Image.open("tmpmedia/" + fname)
im = im.resize(resize, Image.ANTIALIAS)
imageedge = im.filter(ImageFilter.FIND_EDGES)
imageedge.save("edge/" +fname)
blurred = im.filter(ImageFilter.BLUR)
blurred.save("blur/" +fname)
embossed = im.filter(ImageFilter.EMBOSS)
embossed.save("emboss/" +fname)
enhance = im.filter(ImageFilter.EDGE_ENHANCE_MORE)
enhance.save("enhance/" +fname)

#middle text
middle_txt=Image.new('RGB', (382,128))
d = ImageDraw.Draw(middle_txt)
middle_text = title+" by "+author
lines = textwrap.wrap(middle_text, width = 25)
y_text = 30
for line in lines:
    d.text((20,y_text), line, font = font, fill = (255, 255, 0))
    y_text += font_size
middle_top = middle_txt.rotate (270, expand = 0)

#back cover
back_text = "This is a Copyright of Azteka"
back = Image.open("tmpmedia/" + fname)
back = back.resize(resize, Image.ANTIALIAS)
draw = ImageDraw.Draw(back)
lines = textwrap.wrap(back_text, width = 15)
y_text = 20
for line in lines:
    draw.text((20,y_text), line, font = font, fill = (255, 255,0))
    y_text += font_size
draw = ImageDraw.Draw(back)

#front cover
front = Image.open("teaser/"+fname)
middle_bottom = Image.open("thumbnail/"+fname)

#book cover
img_main = Image.new("RGB", (808, 510))
img_main.paste(back, (0,0))
img_main.paste(front, (468,0))
img_main.paste(middle_top, (340,0))
img_main.paste(middle_bottom, (340,383))
img_main.save("cover/"+fname)

#WATERMARK
def watermark(filename, text, outfilename):
    FONT = "bootstrap/fonts/Diavlo.otf"
    img = Image.open(filename).convert("RGB")
    img = img.resize(resize, Image.ANTIALIAS)
    watermark = Image.new("RGBA", (img.size[0], img.size[1]))
    draw = ImageDraw.ImageDraw(watermark, "RGBA")
    size = 0
    while True:
        size += 1
        nextfont = ImageFont.truetype(FONT, size)
        nexttextwidth, nexttextheight = nextfont.getsize(text)
        if nexttextwidth+nexttextheight/3 > watermark.size[0]:
            break
        font = nextfont
        textwidth, textheight = nexttextwidth, nexttextheight
    draw.setfont(font)
    draw.text(((watermark.size[0]-textwidth)/2,
               (watermark.size[1]-textheight)/2), text)
    watermark = watermark.rotate(degrees(atan(float(img.size[1])/
                                              img.size[0])),
                                 Image.BICUBIC)
    mask = watermark.convert("L").point(lambda x: min(x, 55))
    watermark.putalpha(mask)
    img.paste(watermark, None, watermark)
    img.save(outfilename)
watermark("tmpmedia/" + fname,"Azteka","watermark/" +fname)
#EXIF DATA
try:
      ret = {}
      i = Image.open("tmpmedia/"+fname)
      info = i._getexif()
      if info:
           with open('exif_'+isbn+'.txt', 'w') as the_file:
                   for tag, value in info.items():
                            decoded = TAGS.get(tag, tag)
                            ret[decoded] = value
                            the_file.write(str(decoded)+"\t"+str(value)+"\n")	 
except:
      print ("failed")


