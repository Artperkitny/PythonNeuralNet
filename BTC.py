import math
import numpy as np
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot  as plt
from timeit import default_timer as timer
from numpy import *
from numpy import save 
from numpy import load 

#Raw Data 

#Financial Data [Open, High, Low, Close, Volume(BTC), Volume(USD), Weighted Price(USD)]
File = "OkCoinHourdata.txt"
Data = np.loadtxt(File,dtype='float64')

Days = zeros((len(Data)),dtype=float64)
Open = Data[:,0]
High = Data[:,1]
Low = Data[:,2]
Close = Data[:,3]

#Period 
N = 14


#Technical Overlays

#Simple Moving Average(SMA)
def SMA(x,N):
	SMA = zeros((len(x)),dtype=float64)
	count=0
	while(count<=len(SMA)-N):
		SMA[count+N-1] = sum(x[count:count+N])/float(N)
		count+=1
	return SMA
	
#Exponential Moving Average(EMA)
def EMA(x,N):
	EMA = zeros((len(x)),dtype=float64)
	K = 2/(float(N)+1)
	count=0
	while(count<=len(EMA)-N):
		if(count==0):
			EMA[count+N-1] = sum(x[count:count+N])/N
		else:
			EMA[count+N-1] = (EMA[count+N-2]*(1-K))+(x[count+N-1]*(K))
		count+=1
	return EMA

#Cumulative Moving Average(CMA)
def CMA():
	return
	
#Weighted Moving Average(WMA)
def WMA():
	return
	
#Modified Moving Average(MMA)
def MMA(x,N):
	MMA = zeros((len(x)),dtype=float64)
	K = 1/float(N)
	count=0
	while(count<=len(MMA)-N):
		if(count==0):
			MMA[count+N-1] = sum(x[count:count+N])/N
		else:
			MMA[count+N-1] = (MMA[count+N-2]*(1-K))+(x[count+N-1]*(K))
		count+=1
	return MMA

#Technical Indicators

#Average True Range (ATR)
def ATR(open,high,low,close,N):
	High_Low = zeros((len(Data)),dtype=float64)
	High_PreviousClose = zeros((len(Data)),dtype=float64)
	Low_PreviousClose = zeros((len(Data)),dtype=float64)
	True_Range = zeros((len(Data)),dtype=float64)
	ATR = zeros((len(Data)),dtype=float64)
	
	count=0

	while(count<len(Data)):
		#The absolute difference of Today High - Today Low
		High_Low[count] = abs(high[count] - low[count])
		if(count==0):
			High_PreviousClose[count] = 0
			Low_PreviousClose[count] = 0
		else:
			#The absolute difference of Today High - Yesterdays Close
			High_PreviousClose[count] = abs(high[count] - close[count-1])
			#The absolute difference of Yesterdays Close - Today Low
			Low_PreviousClose[count] = abs(close[count-1]- low[count])
		
		count+=1

	#True range is the largest of these three prices
	count=1
	while(count<len(Data)):
		True_Range[count] = max(High_Low[count],High_PreviousClose[count],Low_PreviousClose[count])
		count+=1
	
	ATR = MMA(np.delete(True_Range, 0),N)
	ATR = np.insert(ATR,0,0)
	
	return ATR

#Average Directional Index (ADX)
def ADX(open,high,low,close,N):
	#Variables 
	UpMove = zeros((len(Data)),dtype=float64)
	DownMove = zeros((len(Data)),dtype=float64)
	
	DM_Plus = zeros((len(Data)),dtype=float64)
	DM_Minus = zeros((len(Data)),dtype=float64)
	
	DM_Plus_Avg = zeros((len(Data)),dtype=float64)
	DM_Minus_Avg = zeros((len(Data)),dtype=float64)
	
	Positive_Directional_Indicator = zeros((len(Data)),dtype=float64)
	Negative_Directional_Indicator = zeros((len(Data)),dtype=float64)

	DI = zeros((len(Data)-N),dtype=float64)
	
	ADX = zeros((len(Data)),dtype=float64)
	
	count=1
	
	while(count<len(Data[:,0])):
		#UpMove =  today high - yesterdays high
		UpMove[count] = high[count] - high[count-1]
		#DownMove =  yesterdays low - today low
		DownMove[count] =  low[count-1] - low[count]
		count+=1
	
	count = 1
	
	while(count<len(Data[:,0])):
		if(UpMove[count]<0 and DownMove[count]<0):
			DM_Plus[count] = 0
			DM_Minus[count] = 0
		if(UpMove[count]>DownMove[count] and UpMove[count]>0):
			DM_Plus[count] = UpMove[count]
			DM_Minus[count] = 0
		if(UpMove[count]<DownMove[count] and DownMove[count]>0):
			DM_Plus[count] = 0
			DM_Minus[count] = DownMove[count]
		count+=1

	DM_Plus_Avg = MMA(np.delete(DM_Plus, 0),N)
	DM_Minus_Avg = MMA(np.delete(DM_Minus, 0),N)
	
	DM_Plus_Avg = np.insert(DM_Plus_Avg,0,0)
	DM_Minus_Avg = np.insert(DM_Minus_Avg,0,0)
	
	Average_True_Range = ATR(open,high,low,close,N)
	
	count = N
	
	while(count<len(Data[:,0])):
		#Plus DM14 divided by TR14
		Positive_Directional_Indicator[count] = (DM_Plus_Avg[count]/Average_True_Range[count])*100
		#Minus DM14 divided by TR14
		Negative_Directional_Indicator[count] = (DM_Minus_Avg[count]/Average_True_Range[count])*100
		count+=1
	
	count = N
	
	while(count<len(Data[:,0])):
		DI[count-N]=(abs(Positive_Directional_Indicator[count]-Negative_Directional_Indicator[count])/(Positive_Directional_Indicator[count]+Negative_Directional_Indicator[count]))*100
		count+=1
	
	ADX = MMA(DI,N)
	
	count=0
	while(count<N):
		ADX = np.insert(ADX,0,0)
		DI = np.insert(DI,0,0)
		count+=1
		
	return ADX

#Moving Average Convergence Divergence (MACD)
def MACD(open,high,low,close,a,b):

	#(12-day EMA - 26-day EMA) 
	MACD_Line = zeros((len(Data)),dtype=float64)
	
	MACD_Line = EMA(close,a)-EMA(close,b)
	count = 0
	while(count<b-1):
		MACD_Line[count]=0
		count+=1

	#Signal Line: 9-day EMA of MACD Line
	Signal_Line = EMA(MACD_Line[b-1:],9)

	count = 0
	while(count<b-1):
		Signal_Line = np.insert(Signal_Line,0,0)
		count+=1

	#MACD Histogram: MACD Line - Signal Line
	MACD_Histogram = MACD_Line[b+9-2:]-Signal_Line[b+9-2:]
	count = 0
	while(count<b+9-2):
		MACD_Histogram = np.insert(MACD_Histogram,0,0)
		count+=1
		
	return MACD_Line,Signal_Line,MACD_Histogram
	
#Stochastic Oscillator Fast (Fast_STO)
def Fast_STO():
	return 
	
#Stochastic Oscillator Slow (Slow_STO)
def Slow_STO(open,high,low,close,N):
	#LOW(%K) - is the lowest low in %K periods;
	Low_K = zeros((len(Data)),dtype=float64)
	High_K = zeros((len(Data)),dtype=float64)
	Percent_K = zeros((len(Data)),dtype=float64)
	count=0
	while(count<=len(low)-N):
		Low_K[count+N-1] = min(low[count:N+count])
		High_K[count+N-1] = max(High[count:N+count])
		count+=1
		
	count=0
	while(count<=len(low)-N):
		Percent_K[count+N-1]=(close[count+N-1]- Low_K[count+N-1])/(High_K[count+N-1]-Low_K[count+N-1])*100
		count+=1
	
	#%D = SMA(%K, N) 
	Percent_D = zeros((len(Data)),dtype=float64)
	Percent_D = SMA(Percent_K[N-1:],N)
	
	count=0
	while(count<N):
		Percent_D = np.insert(Percent_D,0,0)
		count+=1

	return Percent_K,Percent_D
	
#Stochastic Oscillator Full (Full_STO)
def Full_STO():
	return 

#On-Balance Volume (OBV)
def OBV():
	return 
	
#Accumulation/Distribution Line (ADL)
def ADL():
	return

#Aroon Oscillator (AO)
def AO():
	return
	
#Relative Strength Index (RSI)
def RSI():
	return


ADX = ADX(Open,High,Low,Close,N)
MACD =  MACD(Open,High,Low,Close,12,26)
Slow_STO = Slow_STO(Open,High,Low,Close,N)

plot = plt.plot(Days)
plot = plt.plot(ADX)
plot = plt.plot(MACD[0])
plot = plt.plot(MACD[1])
plot = plt.plot(MACD[2])
plot = plt.plot(Slow_STO[0])
plot = plt.plot(Slow_STO[1])

file = open("ALlData.csv", "w")
file.write("Hours,ADX,MACD,Signal Line,Histogram,%K,%D,Open,High,Low,Close,Output\n")
count=0

Output = zeros((len(Data)),dtype=float64)

count=0
while(count<len(Data)-1):
	if(Open[count+1]>Open[count]):
		Output[count]=1
	else:
		Output[count]=-1
	count+=1
count=0
while(count<len(Data)):
	file.write("%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n" % (count,ADX[count],MACD[0][count],MACD[1][count],MACD[2][count],Slow_STO[0][count],Slow_STO[1][count],Open[count],High[count],Low[count],Close[count],Output[count]))
	count+=1
file.close()

plt.title('Indicators')
plt.xlabel('Days')
plt.savefig('test.png') 



