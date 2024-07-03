import React, { useEffect, useState } from "react";
import Card from "./Card";
import axios from "axios";

export default function Grid({ objectCards, setCards }) {
  const handleDeleteCard = (cardId) => {
    if (window.confirm("Do you want to delete this card?")) {
      const updatedCards = objectCards?.cards?.filter(
        (card) => card.id !== cardId
      );

      setCards(updatedCards);
      axios
        .delete(`http://localhost:8001/api/card/${cardId}`)
        .then((res) => res.data)
        .then(({ data }) => {
          setCards(data);
          alert("Card deleted!");
        })
        .catch((error) => {
          alert("Card not deleted!");
          console.log(error);
        });
    }
  };

  useEffect(() => {
    axios
      .get(`http://localhost:8001/api/cards`)
      .then((res) => res.data)
      .then(({ data }) => setCards(data));
  }, []);

  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      {objectCards?.cards?.map((card) => (
        <Card key={card.id} card={card} onDelete={handleDeleteCard} />
      ))}
    </div>
  );
}
