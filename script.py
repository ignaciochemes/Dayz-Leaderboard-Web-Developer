from time import sleep
from os.path import getmtime
import json
import mysql.connector
import glob
import sys
import re
from pathlib import Path  

# prepare stuff
JSON_FILES="C:/dayzserver/ServerProfiles/Leaderboard/*.json" # Tipo de archivo a ver
POLLINNG_TIME = 60   # Cada cuanto tiempo detecta cambios (segundos)
FIELDS_TO_INSERT = ["id", "animalsKilled", "name", "deathsToZCount", "deathsToNaturalCauseCount", "deathsToAnimalCount", "suicideCount"
, "longestShot", "zKilled", "timeSurvived", "distTrav"]

sql_insert = "REPLACE INTO NombreTabla ("+ (','.join(FIELDS_TO_INSERT)) +") VALUES ("+ ','.join("%s" for _ in FIELDS_TO_INSERT) +")"


def update_db(file, cursor):
    fname = Path(file).name
    with open(file) as f:
        data = json.load(f)
    data["id"] = re.match("Stats-(\\d*)\\.json", fname).group(1)
    data["animalsKilled"] = len(data["animalsKilled"])
    values = tuple([data[x] for x in FIELDS_TO_INSERT])
    cursor.execute(sql_insert, values)

last_modified_map = {}
db = None
try:
    db = mysql.connector.connect(
        host="localhost",
        user="Usuario",
        passwd="",
        database = "NombreDB"
    )
    cursor = db.cursor()

    while True:
        needs_to_commit = False

        for file in glob.glob(JSON_FILES):
            new_lm = getmtime(file)
            last_modified = last_modified_map.get(file)
            if new_lm != last_modified:
                needs_to_commit = True
                update_db(file, cursor)
            
            last_modified_map[file] = new_lm

        
        if needs_to_commit:
            db.commit()
        
        sleep(POLLINNG_TIME)
finally:
    if db is not None:
        cursor.close()
        db.close()