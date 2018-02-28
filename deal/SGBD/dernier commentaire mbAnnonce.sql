(SELECT max(c.date_enregistrement), a.id
            FROM commentaire c
            JOIN annonce a ON a.membre_id = c.membre_id
            WHERE a.id = c.annonce_id
            GROUP BY a.id)
            ;