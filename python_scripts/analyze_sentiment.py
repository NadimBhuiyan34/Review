import sys
from textblob import TextBlob

def analyze_sentiment(review_text):
    blob = TextBlob(review_text)
    polarity = blob.sentiment.polarity

    positive_threshold = 0.1
    negative_threshold = -0.1

    if polarity > positive_threshold:
        return "Positive"
    elif polarity < negative_threshold:
        return "Negative"
    else:
        return "Neutral"

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Error: Please provide a review as a command-line argument.")
        sys.exit(1)

    review_text = sys.argv[1]
    sentiment = analyze_sentiment(review_text)
    print(sentiment)
