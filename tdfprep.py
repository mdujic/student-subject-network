#!/usr/bin/python3
import sys
sys.path.append("/home/jurica/")
from sklearn.feature_extraction.text import TfidfVectorizer
from pymongo import MongoClient
from bson import json_util
import json
import pandas as pd

MONGODB_HOST = 'localhost'
MONGODB_PORT = 27017
DB_NAME = 'nbp'
COLLECTION_NAME = 'subject'

def getData():
    connection = MongoClient(MONGODB_HOST, MONGODB_PORT)
    collection = connection[DB_NAME][COLLECTION_NAME]
    subjects = collection.find()
    json_subjects = []
    for predmet in subjects:
        json_subjects.append(predmet)
    json_subjects = json.dumps(json_subjects, default=json_util.default)
    connection.close()
    return json_subjects

ret = getData()
#print(ret)
df = pd.read_json(ret)
df = df[['ISVUsifra', 'imePredmeta', 'opis']]
df = df[df.opis != 'Nema opis']

tfidf = TfidfVectorizer()
tfidf_matrix = tfidf.fit_transform(df['opis'])
    
from sklearn.metrics.pairwise import linear_kernel
cosine_sim = linear_kernel(tfidf_matrix, tfidf_matrix)

indices = pd.Series(df.index, index=df['ISVUsifra']).drop_duplicates()

def get_recommendations(ISVUsifra, cosine_sim = cosine_sim):
    idx = indices[ISVUsifra]
    sim_scores = list(enumerate(cosine_sim[idx]))
    sim_scores = sorted(sim_scores, key = lambda x: x[1], reverse = True)
    sim_scores = sim_scores[1:2]
    movie_indices = [i[0] for i in sim_scores]
    return df['imePredmeta'].iloc[movie_indices]

prijedlog = get_recommendations(45693)
print('asdasdas tu sam python!')
ime = prijedlog.iloc[0]
print(ime)

#print(df) 






