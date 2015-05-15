import OkCoin
import math
import numpy as np
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot  as plt
from timeit import default_timer as timer
from numpy import *
from numpy import save 
from numpy import load 
import datetime

def Unix(x):
	return( datetime.datetime.fromtimestamp(int(x)).strftime('%Y-%m-%d %H:%M:%S'))

def OHLC(x,begin_time,interval,count_interval):
	Time = begin_time+interval*count_interval
	price = x[:,1]
	Open = x[0,1]
	High = max(price)
	Low = min(price)
	Close = x[len(x)-1,1]
	
	return Time,Open,High,Low,Close

def Load():
	File = "okcoin.txt"
	Data = np.loadtxt(File,delimiter=',')

	#Data = [timestamp, price, volume]

	begin_time = Data[0,0]

	count=0
	count_interval=0
	count_data=0  

	hour = 60*60
	day = hour*24
	week = day*7
	year = week*52

	interval = hour

	Intervals = math.floor((Data[len(Data)-1,0]-Data[0,0])/interval)
	#Time, Open, High, Low, Close
	Data_Array = zeros((Intervals,5))
	file_name = "smalldata/Data.csv"
	
	while(count_interval<Intervals):
		while(Data[count+count_data,0]<=begin_time+interval*count_interval):
			count+=1
		if(count>0):
			Data_Temp = zeros((count,3))
			count=0
			while(Data[count_data,0]<=begin_time+interval*count_interval):
				Data_Temp[count] = Data[count_data]
				count_data+=1
				count+=1
			Data_Array[count_interval] = OHLC(Data_Temp,begin_time,interval,count_interval)
			Time = begin_time+interval*count_interval
			np.savetxt(file_name, (Data_Array), delimiter=",") 
			
			count=0
			
			count_interval+=1
		else:
			Data_Array[count_interval,0]=begin_time+interval*count_interval
			Data_Array[count_interval,1:4] = Data_Array[count_interval-1,1]
			Time = begin_time+interval*count_interval
			np.savetxt(file_name, (Data_Array), delimiter=",") 
			
			count=0
			count_interval+=1
			
		print Unix((begin_time+interval*count_interval))
		
		
def Update():
	return 
def Live_Update():
	return 
def Get_Info():
	return 
	
Load()