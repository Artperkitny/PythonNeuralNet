import math
import numpy as np, numpy
from timeit import default_timer as timer
from numpy import *
from numpy import save 
from numpy import load 

def Run(IL,H1,H2,OL,B1,count):
	start = timer()
	
	W_L = load("W.npy")
	W2_L = load("W2.npy")
	W3_L = load("W3.npy")
	
	Lr = -1
	BigCount = 0
	
	I = zeros((1,IL))
	#ADX(14)
	I[0,0] = normalize(ADX[count])
	#MACD Histogram(12,26)
	I[0,1] = normalize(Histogram[count])
	#%K
	I[0,2] = normalize(D[count])
	#%D
	I[0,3] = normalize(K[count])
	#Price 5H-
	I[0,4] = normalize(Open[count-5]/100)
	#Price Current 
	I[0,5] = normalize(Open[count]/100)
	
	O2 = zeros((1,H1),dtype=float64)
	O3 = zeros((1,H2),dtype=float64)
	O4 = zeros((1,OL),dtype=float64)
	
	W = W_L
	W2 = W2_L
	W3 = W3_L
	
	count1 = 0
	count2 = 0
	count3 = 0
	
	while(count1<H1):
		O2[0,count1]= (sum((W*I)[count1]))
		count1+=1

	
	while(count2<H2):
		O3[0,count2]= (sum((W2*O2)[count2]))
		count2+=1

	
	while(count3<OL):	
		O4[0,count3] = (sum((W3*O3)[count3]))
		Output[count-5]=O4[0,count3]
		count3+=1
		


def Generate_NN(IL,H1,H2,OL,B1,count):
	
	W_L = load("W.npy")
	W2_L = load("W2.npy")
	W3_L = load("W3.npy")
	
	OD = zeros((1,OL))
	OD[0,0]=Output[count]
	Lr = -1
	BigCount = 0
	BigCount2 = 0
	Done="false"
	
	I = zeros((1,IL))
	
	#ADX(14)
	I[0,0] = normalize(ADX[count])
	#MACD Histogram(12,26)
	I[0,1] = normalize(Histogram[count])
	#%K
	I[0,2] = normalize(D[count])
	#%D
	I[0,3] = normalize(K[count])
	#Price 5H-
	I[0,4] = normalize(Open[count-5]/100)
	#Price Current 
	I[0,5] = normalize(Open[count]/100)
	
	O2 = zeros((1,H1),dtype=float64)
	O3 = zeros((1,H2),dtype=float64)
	O4 = zeros((1,OL),dtype=float64)
	
	if(count==len(Data)-168):
		W = random.rand(H1,IL)
		W2 = random.rand(H2,H1)
		W3 = random.rand(OL,H2)
		print "New Weights Generated"
	else:
		W = W_L
		W2 = W2_L
		W3 = W3_L
	
	count1 = 0
	count2 = 0
	count3 = 0
	
	while(count1<H1):
		O2[0,count1]= (sum((W*I)[count1]))
		count1+=1
		
	while(count2<H2):
		O3[0,count2]= (sum((W2*O2)[count2]))
		count2+=1
	
	while(count3<OL):	
		O4[0,count3] = (sum((W3*O3)[count3]))
		count3+=1

	while (BigCount2<100000):
		count1 = 0
		count2 = 0
		count3 = 0
		
		while(count1<H1):
			O2[0,count1]=(sum((W*I)[count1]))
			count1+=1
		
		while(count2<H2):
			O3[0,count2]=(sum((W2*O2)[count2]))
			count2+=1
		
		while(count3<OL):	
			O4[0,count3] =(sum((W3*O3)[count3]))
			count3+=1
		
		#BackPropegation 
		
		O2_D = zeros((1,H1),dtype=float64)
		O3_D = zeros((1,H2),dtype=float64)
		O4_D = zeros((1,OL),dtype=float64)
		
		W_A = ones((H1,IL),dtype=float64)
		W2_A = ones((H2,H1),dtype=float64)
		W3_A = ones((OL,H2),dtype=float64)
		
		count1 = 0
		count2 = 0
		count3 = 0
		
		while(count3<OL):	
			O4_D[0,count3] = normalize(O4[0,count3])*(1-normalize(O4[0,count3]))*(normalize(O4[0,count3])-normalize(OD[0,count3]))
			count3+=1

		
		while(count2<H2):
			O3_D[0,count2] = normalize(O3[0,count2])*(1-normalize(O3[0,count2]))*sum(O4_D*W3[0:OL,count2])
			count2+=1


		while(count1<H1):
			O2_D[0,count1] = normalize(O2[0,count1])*(1-normalize(O2[0,count1]))*sum(O3_D*W2[0:H2,count1])
			count1+=1

		
		count1 = 0
		count2 = 0
		count3 = 0
		
		while(count3<OL):	
			W3_A[count3] = Lr*O4_D[0,count3]*O3
			count3+=1
		
		while(count2<H2):	
			W2_A[count2] = Lr*O3_D[0,count2]*O2
			count2+=1

		while(count1<H1):
			W_A[count1] = Lr*O2_D[0,count1]*I
			count1+=1
		
		W+=W_A
		W2+=W2_A
		W3+=W3_A
		BigCount+=1
		BigCount2+=1
		
		if(np.allclose(OD,O4) and Done=="false"):
			BigCount2=100000
			Done="true"
		print O4 
	
	count1 = 0
	count2 = 0
	count3 = 0

	
	while(count1<H1):
		O2[0,count1]= (sum((W*I)[count1]))
		count1+=1

	while(count2<H2):
		O3[0,count2]= (sum((W2*O2)[count2]))
		count2+=1
	
	while(count3<OL):	
		O4[0,count3] = (sum((W3*O3)[count3]))
		count3+=1
	
	np.save("W.npy", W)
	np.save("W2.npy", W2)
	np.save("W3.npy", W3)
	
def normalize(O):
    return (1/(1+(math.exp(-O*0.01))))
	
start = timer()	
IL = 6	
H1 = 30
H2 = 15
OL = 1
B1 = 0

File = "Training.txt"
Data = np.loadtxt(File,dtype='float64')

ADX = Data[:,1]
Histogram = Data[:,4]
D = Data[:,5]
K = Data[:,6]
Open = Data[:,7]
Output = Data[:,11]

count=len(Data)+1680

while(count<len(Data)):
	Generate_NN(IL,H1,H2,OL,B1,count)
	print "Training Set",count-len(Data)-168
	count+=1
	
File = "Outputs.txt"
Data = np.loadtxt(File,dtype='float64')
	
ADX = Data[:,1]
Histogram = Data[:,4]
D = Data[:,5]
K = Data[:,6]
Open = Data[:,7]
Output = zeros((len(Data)-5),dtype=float64)

count=5

while(count<len(Data)):
	Run(IL,H1,H2,OL,B1,count)
	print "Training Set",count-4
	count+=1

print Output

time = timer()-start
print  ("Seconds to execute script: " + str(time))