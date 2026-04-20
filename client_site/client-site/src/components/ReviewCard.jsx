export default function ReviewCard({ review }) {
  const stars = '★'.repeat(review.stars) + '☆'.repeat(5 - review.stars)

  return (
    <div className="review-card">
      <div className="review-stars">{stars}</div>
      <p className="review-text">"{review.text}"</p>
      <p className="review-author">— {review.author}</p>
    </div>
  )
}