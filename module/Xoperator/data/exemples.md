//usando navito sql
        //SELECT
        $query = $this->getEntityManager()->createQuery("SELECT u.id, u.title, u.text FROM Xoperator\EntityTable\Articles u WHERE u.title LIKE :titletxt");
        $query->setParameter('titletxt', '%bola%');
                
        //isto é um array
        $users = $query->getResult();

        //UPDATE
        $query = $this->getEntityManager()->createQuery("UPDATE Xoperator\EntityTable\Articles u SET u.title = '55 alterado por update' WHERE u.id = 4");
        $query->execute();

//-------------//

        