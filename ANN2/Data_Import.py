import math
import numpy as np
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot  as plt
from timeit import default_timer as timer
from numpy import *
from numpy import save 
from numpy import load 
import urllib
import urllib2
import hashlib
import simplejson

def get_json(url):
	response = urllib2.urlopen(url)
	data = simplejson.load(response)
	return(data)
        
def ticker():
	btc_ticker_url = 'http://api.bitcoincharts.com/v1/trades.csv?symbol=okcoinCNY'

	data = get_json(btc_ticker_url)
	return(data)

print ticker()
