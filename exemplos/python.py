import requests as rs
import json 

url = ""

pay_load = {'type': 'ranking_general'}

headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}

dados = rs.post(url, data=json.dumps(pay_load), headers=headers)

dicionario = json.loads(dados.text)

print(dicionario);

for score in dicionario:
    print('User:', str(score.get('User')))
    print('Score:', str(score.get('Score')))
    print("")