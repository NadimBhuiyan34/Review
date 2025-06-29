import sys
from textblob import TextBlob

def analyze_sentiment(review_text):
    blob = TextBlob(review_text)
    polarity = blob.sentiment.polarity

    positive_threshold = 0.1
    negative_threshold = -0.1
    fuzzy_margin = 0.1  # wider margin for fuzzy classification

    if polarity > positive_threshold + fuzzy_margin:
        return "Positive"
    elif polarity < negative_threshold - fuzzy_margin:
        return "Negative"
    elif (positive_threshold - fuzzy_margin) <= polarity <= (positive_threshold + fuzzy_margin):
        return "Fuzzy Positive"
    elif (negative_threshold - fuzzy_margin) <= polarity <= (negative_threshold + fuzzy_margin):
        return "Fuzzy Negative"
    else:
        return "Neutral"

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Error: Please provide a review as a command-line argument.")
        sys.exit(1)

    review_text = sys.argv[1]
    sentiment = analyze_sentiment(review_text)
    print(sentiment)
