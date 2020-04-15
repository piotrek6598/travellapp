import os
from pathlib import Path

PATH_TO_BASEDIR = str(Path(__file__).parent.absolute())
PATH_TO_CONFIG = os.path.join(PATH_TO_BASEDIR, 'config.yml')
PATH_TO_LOGS = os.path.join(PATH_TO_BASEDIR, 'logs.txt')
