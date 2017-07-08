import csv
import MySQLdb

#Open connection to database
mydb = MySQLdb.connect(host='localhost',
    user='root',
    passwd='8765',
    db='library')
cursor = mydb.cursor()

csv_data = csv.reader(file('data/books_actual_set.csv'))
i=0

for row in csv_data:
    
    i+=1
    print(i)
    
    data = (row[0],row[1],row[4])
    #print(data)
    try:
        cursor.execute("INSERT INTO book VALUES(%s, %s, %s)", data)
    except:
        print("Duplicate Entry in book")

    data = (row[3],row[2])
    #print(data)
    try:
        cursor.execute("INSERT INTO authors VALUES(%s, %s)", data)
    except:
        print("Duplicate Entry in authors")

    data = (row[3],row[0])
    #print(data)
    try:
        cursor.execute("INSERT INTO book_authors VALUES(%s, %s)", data)
    except:
        print("Duplicate Entry in book_authors")


csv_data = csv.reader(file('data/borrowers_actual_set.csv'))
i=0
for row in csv_data:
    
    i+=1
    print(i)

    data = (row[0], row[1], row[2]+' '+row[3], row[5]+','+row[6]+','+row[7], row[8])
    #print(data)
    try:
        cursor.execute("INSERT INTO borrowers VALUES(%s, %s, %s, %s, %s)", data)
    except:
        print("Duplicate Entry in borrowers")

csv_data = csv.reader(file('data/auth_users.csv'))
i=0
for row in csv_data:
    
    i+=1
    print(i)

    data = (row[0], row[1], row[2])
    #print(data)
    try:
        cursor.execute("INSERT INTO auth_users VALUES(%s, %s, %s)", data)
    except:
        print("Duplicate Entry in auth_users")

#Close the connection to the database.
mydb.commit()
cursor.close()
print "Done" 