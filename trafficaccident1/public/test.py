import sys
import json

import pandas as pd



from sklearn.cluster import KMeans
from math import*
def isnumber(aString):#資料前置處理判斷是否為整數
    try:

        float(aString)

        return True

    except:

        return False

    
def Distance1(Lat_A,Lng_A,Lat_B,Lng_B): #計算兩經緯度距離方法
    if(Lat_A==Lat_B and Lng_A==Lng_B):
         return 0
    ra=6378.140 #赤道半徑
    rb=6356.755 #極半徑 （km）
    flatten=(ra-rb)/ra  #地球偏率
    rad_lat_A=radians(Lat_A)
    rad_lng_A=radians(Lng_A)
    rad_lat_B=radians(Lat_B)
    rad_lng_B=radians(Lng_B)
    pA=atan(rb/ra*tan(rad_lat_A))
    pB=atan(rb/ra*tan(rad_lat_B))
    xx=acos(sin(pA)*sin(pB)+cos(pA)*cos(pB)*cos(rad_lng_A-rad_lng_B))
    c1=(sin(xx)-xx)*(sin(pA)+sin(pB))**2/cos(xx/2)**2
    c2=(sin(xx)+xx)*(sin(pA)-sin(pB))**2/sin(xx/2)**2
    dr=flatten/8*(c1-c2)
    distance=ra*(xx+dr)
    return distance

ta_log=pd.read_csv('/opt/lampp/htdocs/trafficaccident/public/data/persons.csv',low_memory= False,encoding='utf-8')
print(0)
#資料前置處理
daa=pd.DataFrame(columns=['latitude', 'longitude'])
daa['latitude']=list(ta_log.iloc[0,:])
daa['longitude']=list(ta_log.iloc[1,:])
num=daa['latitude'][0]
co=0
for i in range(len(daa)):
    num=daa['latitude'][i]
    num1=daa['longitude'][i]
    if(isnumber(num)==False or isnumber(num1)==False):
        daa=daa.drop(index=i)
daa=daa.reset_index()
daa=daa.drop('index',axis=1)


#進行分群
cluster=0
ch=int(len(daa)/3)
if(ch>=50):
    cluster=50
elif(ch<50 and ch>10):
    cluster=10
elif(ch<=10 and ch>5):
    cluster=5
else:
    cluster=len(daa)
km_c3 = KMeans(n_clusters = cluster,
              init = 'k-means++',
              n_init = 10,
              max_iter = 300,
              tol = 1e-04,
              random_state =0)
km_y = km_c3.fit_predict(daa)
centers = km_c3.cluster_centers_
latitude=[]
longitude=[]
print(0)
#分群完資料開新的dataframe
for i in range(len(centers)):
    latitude.append(centers[i][0])
    longitude.append(centers[i][1])
an=pd.DataFrame(columns=['latitude', 'longitude'])
an['latitude']=latitude
an['longitude']=longitude

#開啟員警巡邏點位
ta_patrol=pd.read_csv('/opt/lampp/htdocs/trafficaccident/public/data/police.csv',low_memory= False,encoding='utf-8')
ta_patrol=ta_patrol.dropna(axis=1)
print(ta_patrol)
daa=pd.DataFrame(columns=['latitude', 'longitude'])
daa['latitude']=list(ta_patrol.iloc[0,:])
daa['longitude']=list(ta_patrol.iloc[1,:])


num=daa['latitude'][0]
co=0
for i in range(len(daa)):
    num=daa['latitude'][i]
    num1=daa['longitude'][i]
    if(isnumber(num)==False or isnumber(num1)==False):
        daa=daa.drop(index=i)
daa=daa.reset_index()
daa=daa.drop('index',axis=1)

print(0)
#點與圓心距離小於等於半徑250
#warm為判斷是否滿足條件
warm=[]
for i in range(len(an)):
    num=0
    for j in range(len(daa)):
        dist=Distance1(an['latitude'][i],an['longitude'][i],daa['latitude'][j],daa['longitude'][j])
        dist=dist*1000
        if(dist<=250):
            num+=1
        if(num>=3):
            warm.append('G')
            break
        if(j==len(daa)-1 and num<3):
            warm.append('R')
an['warm']=warm
name1=sys.argv[1]
name2=sys.argv[2]
print(0)
#判斷完成存成csv
an.to_csv('/opt/lampp/htdocs/trafficaccident/public/data/'+name1+name2+'dot.csv',index=0)
