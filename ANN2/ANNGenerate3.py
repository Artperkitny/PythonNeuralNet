import math
import numpy as np, numpy
from timeit import default_timer as timer
from numpy import *
from numpy import save 
from numpy import load 
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot  as plt

start = timer()

def Run(IL,H1,H2,OL):
	
	W_L = load("W.npy")
	W2_L = load("W2.npy")
	W3_L = load("W3.npy")
	
	I = ones((1,IL))
	I[0,0] = ADX[(Test_Length)]
	I[0,1] = Histogram[(Test_Length)]
	I[0,2] = K[(Test_Length)]
	I[0,3] = D[(Test_Length)]
	I[0,4] = Open[(Test_Length)]
	
	print ADX[(Test_Length)]
	print Histogram[(Test_Length)]
	print K[(Test_Length)]
	print D[(Test_Length)]
	print Open[(Test_Length)]
	
	Comp_Value = Output[(Test_Length)]
	
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
		count3+=1
	
	return O4

	
def SSE():
	SSE = abs(((sum(Result_Actual)-sum(Result_Desired))/sum(Result_Desired))*100)
	Total_SSE[Training_Set_Count]  = SSE
	return SSE
def Train(IL,H1,H2,OL):
	
	W_L = load("W.npy")
	W2_L = load("W2.npy")
	W3_L = load("W3.npy")
	
	OD = ones((1,OL))
	OD[0,0]  = Output[(Training_Rep_Count)]
	
	Lr = -1
	BigCount = 0
	BigCount2 = 0
	Done="false"
	
	I = ones((1,IL))
	I[0,0] = ADX[(Training_Rep_Count)]
	I[0,1] = Histogram[(Training_Rep_Count)]
	I[0,2] = K[(Training_Rep_Count)]
	I[0,3] = D[(Training_Rep_Count)]
	I[0,4] = Open[(Training_Rep_Count)]
	
	O2 = zeros((1,H1),dtype=float64)
	O3 = zeros((1,H2),dtype=float64)
	O4 = zeros((1,OL),dtype=float64)
	
	if(Training_Set_Count==0 and Training_Rep_Count==0):
		print "New Weights"
		W = random.rand(H1,IL)/10
		W2 = random.rand(H2,H1)/10
		W3 = random.rand(OL,H2)/10
	else:
		print "Loading Weights"
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
	print ("DO: %s AO: %s" %( Output[Training_Rep_Count],O4[0,0]))
	Error = abs(((Output[Training_Rep_Count]-O4[0,0])/(O4[0,0]))*100)	
	print ("Error: %s percent" % Error)
	
	Result_Actual[Training_Rep_Count] = O4
	Result_Desired[Training_Rep_Count] = Output[Training_Rep_Count]
	
	np.save("W.npy", W)
	np.save("W2.npy", W2)
	np.save("W3.npy", W3)	
def normalize(O):
    return (1/(1+(math.exp(-O*0.01))))
	
IL = 5
H1 = 50
H2 = 30
OL = 1

File = "Train.txt" 
Data = np.loadtxt(File,dtype='float64')

ADX = Data[33:,0]
Histogram = Data[33:,3]
K = Data[33:,4]
D = Data[33:,5]
Open = Data[33:,6]/1000
Output = Data[34:,9]/1000

Initial_Out = Data[34,9]/1000

Run_Count = 0
Run_Result = ones(50)

Test_Length = 50

while(Run_Count<50):
	Training_Rep_Count = 0
	Training_Set_Count = 0
	Result_Actual = zeros(Test_Length)
	Result_Desired = zeros(Test_Length)
	Total_SSE = zeros(5)
	
	print ("Run: %s" % Run_Count)
	while(Training_Set_Count<5):
		print ("Set: %s" % Training_Set_Count)
		while(Training_Rep_Count<Test_Length):
			print ("Rep: %s" % Training_Rep_Count)
			Train(IL,H1,H2,OL)
			Training_Rep_Count+=1
		SSE()
		Training_Rep_Count=0
		Training_Set_Count+=1
	plot = plt.plot(Total_SSE)
	plt.title('Global Network Error')
	plt.xlabel('Training Epochs')
	plt.ylabel('Error')
	plt.savefig('Global_Error_%s.png' % Run_Count) 
	Run_Result[Run_Count] = Run(IL,H1,H2,OL)
	
	ADX = np.delete(ADX, 0, 0)
	Histogram = np.delete(Histogram, 0, 0)
	K = np.delete(K, 0, 0)
	D = np.delete(D, 0, 0)
	Open = np.delete(Open, 0, 0)
	Output = np.delete(Output, 0, 0)

	Run_Count+=1

count=0

while(count<=len(Run_Result)):
	print Run_Result[count]
	count+=1
	

time = timer()-start
print  ("Seconds to execute script: " + str(time))