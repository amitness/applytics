"""
We have the list of comments and their sentiments.
This trains the system with this pre-classified texts.
"""

from naiveBayesClassifier import tokenizer
from naiveBayesClassifier.trainer import Trainer
from naiveBayesClassifier.classifier import Classifier

sentimentTrainer = Trainer(tokenizer)

# Get the training dataset.
with open('training.csv', 'r') as f:
    data = f.read()
trainset = data.splitlines()

for line in trainset:
    pos1 = line.find(',"')
    pos2 = line.find('",', pos1)
    if pos1 == -1:
        pos1 = line.find(',')
        pos2 = line.find(',', pos1 + 1)
        comment = line[pos1 + 1:pos2]
        sentiment = line[pos2 + 1:]
    else:
        comment = line[pos1 + 2:pos2 - 2]
        sentiment = line[pos2 + 2:]
    sentimentTrainer.train(comment, sentiment)

# Use the classifier.
sentimentClassifier = Classifier(sentimentTrainer.data, tokenizer)

# Classify an unknown review.
unknownInstance = "I don't like the app. It crashes everytime."
classification = sentimentClassifier.classify(unknownInstance)

print classification
