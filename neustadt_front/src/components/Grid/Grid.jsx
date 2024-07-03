import React, { useEffect, useState } from "react";
import Card from "../Card";
import axios from "axios";
import "./overlay.css";

export default function Grid({ objectCards, setCards }) {
  const [isLoading, setLoading] = useState(false);

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
    setLoading(true);

    axios
      .get(`http://localhost:8001/api/cards`)
      .then((res) => res.data)
      .then(({ data }) => {
        setCards(data);
        setLoading(false);
      })
      .catch((error) => {
        setLoading(false);
        console.error("Error fetching cards:", error);
      });
  }, []);

  return (
    <div className="relative">
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        {objectCards?.cards?.map((card) => (
          <Card key={card.id} card={card} onDelete={handleDeleteCard} />
        ))}
      </div>

      {isLoading && (
        <div className="overlay">
          <div className="spinner-border text-dark" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      )}
    </div>
  );
}
